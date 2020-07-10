<template>
  <div class="app-container">
    <div class="filter-container">
      <el-button
        v-permission="['manage department']"
        class="filter-item"
        type="primary"
        icon="el-icon-plus"
        @click="handleCreate"
      >{{ $t('table.add') }}</el-button>
    </div>
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
        v-permission="['manage department']"
        align="center"
        label="Actions"
        width="350"
      >
        <template slot-scope="scope">
          <el-button
            v-permission="['manage department']"
            type="primary"
            size="small"
            icon="el-icon-edit"
            @click="handleEdit(scope.row.id, scope.row.name)"
          >Edit</el-button>
          <el-button
            v-permission="['manage department']"
            type="danger"
            size="small"
            icon="el-icon-delete"
            @click="handleDelete(scope.row.id, scope.row.name);"
          >Delete</el-button>
        </template>
      </el-table-column>
    </el-table>

    <pagination
      v-show="total>0"
      :total="total"
      :page.sync="listQuery.page"
      :limit.sync="listQuery.limit"
      @pagination="getList"
    />

    <el-dialog
      v-permission="['manage department']"
      :title="formTitle"
      :visible.sync="departmentFormVisible"
    >
      <div class="form-container">
        <el-form
          ref="departmentForm"
          :model="currentDepartment"
          label-position="left"
          label-width="150px"
          style="max-width: 500px"
        >
          <el-form-item label="Name" prop="name">
            <el-input v-model="currentDepartment.name" />
          </el-form-item>
          <el-form-item label="Description" prop="description">
            <el-input v-model="currentDepartment.description" />
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="departmentFormVisible = false">Cancel</el-button>
          <el-button :disabled="submitted" type="primary" @click="handleSubmit">Confirm</el-button>
        </div>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import Resource from '@/api/resource';
import permission from '@/directive/permission';
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination

const departmentResource = new Resource('departments');

export default {
  name: 'DepartmentList',
  components: { Pagination },
  directives: { permission },
  data() {
    return {
      list: [],
      listQuery: {
        page: 1,
        limit: 20,
      },
      total: 0,
      loading: true,
      departmentFormVisible: false,
      currentDepartment: {},
      submitted: false,
      formTitle: '',
    };
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      this.loading = true;
      const { data } = await departmentResource.list(this.listQuery);
      console.log(data);
      this.list = data.data;
      this.total = data.total;
      console.log(this.total)
      this.loading = false;
    },
    handleCreate() {
      this.departmentFormVisible = true;
      this.resetForm();
      this.formTitle = 'Create New Department';
    },
    handleSubmit() {
      this.submitted = true;
      if (this.currentDepartment.id !== undefined) {
        departmentResource
          .update(this.currentDepartment.id, this.currentDepartment)
          .then(response => {
            this.$message({
              type: 'success',
              message: 'Department info has been updated successfully',
              duration: 5 * 1000,
            });
            this.getList();
            this.submitted = false;
          })
          .catch(error => {
            console.log(error);
          })
          .finally(() => {
            this.departmentFormVisible = false;
            this.submitted = false;
          });
      } else {
        departmentResource
          .store(this.currentDepartment)
          .then(response => {
            this.$message({
              message:
                'New Department ' +
                this.currentDepartment.name +
                ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.resetForm();
            this.departmentFormVisible = false;
            this.submitted = false;
            this.getList();
          })
          .catch(error => {
            console.log(error);
          });
      }
    },
    handleDelete(id, name) {
      this.$confirm(
        'This will permanently delete department ' + name + '. Continue?',
        'Warning',
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
        }
      )
        .then(() => {
          departmentResource.destroy(id).then(response => {
            this.$message({
              type: 'success',
              message: 'Delete completed',
            });
          });
          this.getList();
        })
        .catch(() => {
          this.$message({
            type: 'info',
            message: 'Delete canceled',
          });
        });
    },

    handleEdit(id, name) {
      this.formTitle = 'Edit Department ' + name;
      this.currentDepartment = this.list.find(
        department => department.id === id
      );
      this.departmentFormVisible = true;
    },

    resetForm() {
      this.currentDepartment = {
        name: '',
        description: '',
      };
    },
  },
};
</script>

