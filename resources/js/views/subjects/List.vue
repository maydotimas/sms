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
        v-permission="['manage subject']"
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

      <el-table-column align="center" label="Category">
        <template slot-scope="scope">
          <span>{{ scope.row.categories }}</span>
        </template>
      </el-table-column>

      <el-table-column
        v-permission="['view subject','manage subject']"
        align="center"
        label="Actions"
        width="350"
      >
        <template slot-scope="scope">
          <el-button
            v-permission="['manage subject']"
            type="primary"
            size="small"
            icon="el-icon-edit"
            @click="handleEditForm(scope.row.id, scope.row.name);"
          >Edit</el-button>
          <el-button
            v-permission="['manage subject']"
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
      v-permission="['view subject','manage subject']"
      :title="formTitle"
      :visible.sync="subjectFormVisible"
    >
      <div class="form-container">
        <el-form
          ref="subjectForm"
          :model="currentSubject"
          label-position="left"
          label-width="150px"
          style="max-width: 500px;"
        >
          <el-form-item label="Name" prop="name">
            <el-input v-model="currentSubject.name" />
          </el-form-item>
          <el-form-item label="Description" prop="description">
            <el-input v-model="currentSubject.description" type="textarea" />
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="subjectFormVisible = false">Cancel</el-button>
          <el-button type="primary" :disabled="submitted" @click="handleSubmit">Confirm</el-button>
        </div>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import Resource from '@/api/resource';
import permission from '@/directive/permission'; // Import permission directive
import waves from '@/directive/waves'; // Import permission directive
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination

const subjectResource = new Resource('subjects');
const subjectCategoryResource = new Resource('categories');

export default {
  name: 'SubjectList',
  directives: { permission, waves }, // use permission directive
  components: { Pagination }, // use permission directive
  data() {
    return {
      list: [],
      subjectList: [],
      listQuery: {
        page: 1,
        limit: 20,
        title: '',
      },
      total: 0,
      loading: true,
      subjectFormVisible: false,
      currentSubject: {},
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
      const { data } = await subjectResource.list(this.listQuery);
      this.list = data.data;
      this.total = data.total;
      this.loading = false;
    },
    async getCategoryList() {
      this.loading = true;
      const { data } = await subjectCategoryResource.list(this.listQuery);
      this.subjectList = data.data;
      this.loading = false;
    },
    /* Submit Store */
    handleSubmit() {
      this.submitted = true;
      if (this.currentSubject.id !== undefined) {
        alert();
        subjectResource
          .update(this.currentSubject.id, this.currentSubject)
          .then(response => {
            this.$message({
              type: 'success',
              message: 'Subject info has been updated successfully',
              duration: 5 * 1000,
            });
            this.getList();
          })
          .catch(error => {
            console.log(error);
          })
          .finally(() => {
            this.subjectFormVisible = false;
            this.submitted = false;
          });
      } else {
        subjectResource
          .store(this.currentSubject)
          .then(response => {
            this.$message({
              message:
                'New subject ' +
                this.currentSubject.name +
                ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.currentSubject = {
              name: '',
              description: '',
            };
            this.getList();
          })
          .catch(error => {
            console.log(error);
          })
          .finally(() => {
            this.subjectFormVisible = false;
            this.submitted = false;
          });
      }
    },
    /* Show Dialog */
    handleCreate() {
      this.formTitle = 'Create new subject';
      this.subjectFormVisible = true;
      this.currentSubject = {
        name: '',
        description: '',
      };
    },
    /* Delete  */
    handleDelete(id, name) {
      this.$confirm(
        'This will permanently delete subject ' + name + '. Continue?',
        'Warning',
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
        }
      )
        .then(() => {
          subjectResource
            .destroy(id)
            .then(response => {
              this.$message({
                type: 'success',
                message: 'Delete completed',
              });
              this.getList();
              console.log(response.data);
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
      this.formTitle = 'Edit subject';
      this.currentSubject = this.list.find(subject => subject.id === id);
      console.log(this.currentSubject);
      this.subjectFormVisible = true;
    },
  },
};
</script>
