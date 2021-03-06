<!-- File: resources/js/views/categories/List.vue -->
<template>
  <div class="app-container">
    <!-- Action Buttons -->
    <div class="filter-container">
      <el-input
        v-model="listQuery.title"
        :placeholder="$t('table.search')"
        style="width: 200px;"
        class="filter-item"
        @keyup.enter.native="getList"
      />
      <el-button
        v-waves
        class="filter-item"
        type="primary"
        icon="el-icon-search"
        @click="getList"
      >{{ $t('table.search') }}</el-button>
      <el-button
        v-permission="['manage category']"
        class="filter-item"
        type="primary"
        icon="el-icon-plus"
        @click="handleCreate"
      >{{ $t('table.add') }}</el-button>
    </div>
    <!-- Table -->
    <el-table v-loading="loading" :data="list" border fit highlight-current-row>
      <el-table-column align="center" label="ID" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Name" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Code" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.code }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Description">
        <template slot-scope="scope">
          <span>{{ scope.row.description }}</span>
        </template>
      </el-table-column>

      <el-table-column
        v-permission="['view category','manage category']"
        align="center"
        label="Actions"
        width="350"
      >
        <template slot-scope="scope">
          <el-button
            v-permission="['manage category']"
            type="primary"
            size="small"
            icon="el-icon-edit"
            @click="handleEditForm(scope.row.id, scope.row.name);"
          >Edit</el-button>
          <el-button
            v-permission="['manage category']"
            type="danger"
            size="small"
            icon="el-icon-delete"
            @click="handleDelete(scope.row.id, scope.row.name);"
          >Delete</el-button>
        </template>
      </el-table-column>
    </el-table>

    <!-- Pagination -->
    <pagination
      v-show="total>0"
      :total="total"
      :page.sync="listQuery.page"
      :limit.sync="listQuery.limit"
      @pagination="getList"
    />

    <!-- Dialog -->
    <el-dialog
      v-permission="['view category','manage category']"
      :title="formTitle"
      :visible.sync="categoryFormVisible"
    >
      <div class="form-container">
        <el-form
          ref="categoryForm"
          :model="currentCategory"
          label-position="left"
          label-width="150px"
          style="max-width: 500px;"
        >
          <el-form-item label="Name" prop="name">
            <el-input v-model="currentCategory.name" />
          </el-form-item>
          <el-form-item label="Description" prop="description">
            <el-input v-model="currentCategory.description" type="textarea" />
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="categoryFormVisible = false">Cancel</el-button>
          <el-button type="primary" :disabled="submitted" @click="handleSubmit">Confirm</el-button>
        </div>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import Resource from '@/api/resource';
const categoryResource = new Resource('categories');
import permission from '@/directive/permission'; // Import permission directive
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination

export default {
  name: 'CategoryList',
  directives: { permission }, // use permission directive
  components: { Pagination }, // use permission directive
  data() {
    return {
      list: [],
      listQuery: {
        page: 1,
        limit: 20,
        title: '',
      },
      total: 0,
      loading: true,
      categoryFormVisible: false,
      currentCategory: {},
      submitted: false,
      formTitle: '',
    };
  },
  created() {
    this.getList();
  },
  methods: {
    /* Get List (ASYNC KASE NEED YUNG RETURN NG Category resource before magreturn ng data) */
    async getList() {
      this.loading = true;
      const { data } = await categoryResource.list(this.listQuery);
      this.list = data.data;
      this.total = data.total;
      this.loading = false;
    },
    /* Submit Store */
    handleSubmit() {
      this.submitted = true;
      if (this.currentCategory.id !== undefined) {
        categoryResource
          .update(this.currentCategory.id, this.currentCategory)
          .then(response => {
            this.$message({
              type: 'success',
              message: 'Category info has been updated successfully',
              duration: 5 * 1000,
            });
            this.getList();
          })
          .catch(error => {
            console.log(error);
          })
          .finally(() => {
            this.categoryFormVisible = false;
            this.submitted = false;
          });
      } else {
        categoryResource
          .store(this.currentCategory)
          .then(response => {
            this.$message({
              message:
                'New category ' +
                this.currentCategory.name +
                ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.currentCategory = {
              name: '',
              description: '',
            };
            this.getList();
          })
          .catch(error => {
            console.log(error);
          })
          .finally(() => {
            this.categoryFormVisible = false;
            this.submitted = false;
          });
      }
    },
    /* Show Dialog */
    handleCreate() {
      this.formTitle = 'Create new category';
      this.categoryFormVisible = true;
      this.currentCategory = {
        name: '',
        description: '',
      };
    },
    /* Delete  */
    handleDelete(id, name) {
      this.$confirm(
        'This will permanently delete category ' + name + '. Continue?',
        'Warning',
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
        }
      )
        .then(() => {
          categoryResource
            .destroy(id)
            .then(response => {
              this.$message({
                type: 'success',
                message: 'Delete completed',
              });
              this.getList();
            })
            .catch(error => {
              console.log(error);
            });
        })
        .catch(() => {
          this.$message({
            type: 'info',
            message: 'Delete canceled',
          });
        });
    },
    /* Edit */
    handleEditForm(id) {
      this.formTitle = 'Edit category';
      this.currentCategory = this.list.find(category => category.id === id);
      this.categoryFormVisible = true;
    },
  },
};
</script>
