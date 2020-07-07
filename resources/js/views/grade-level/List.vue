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

      <el-table-column align="center" label="Code" width="100">
        <template slot-scope="scope">
          <span>{{ scope.row.code }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Description" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.description }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Department" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.department.name }}</span>
        </template>
      </el-table-column>

      <el-table-column
        align="center"
        label="Actions"
        width="200"
      >
        <template slot-scope="scope">
          <el-button
            type="primary"
            size="small"
            icon="el-icon-edit"
            @click="handleEdit(scope.row.id, scope.row.name)"
          >Edit</el-button>
          <el-button
            type="danger"
            size="small"
            icon="el-icon-delete"
            @click="handleDelete(scope.row.id, scope.row.name);"
          >Delete</el-button>
        </template>
      </el-table-column>
    </el-table>

    <el-dialog
      :title="formTitle"
      :visible.sync="gradeLevelFormVisible"
    >
      <div class="form-container">
        <el-form
          ref="gradeLevelForm"
          :model="currentGradeLevel"
          label-position="left"
          label-width="150px"
          style="max-width: 500px"
        >
          <el-form-item label="Name" prop="name">
            <el-input v-model="currentGradeLevel.name" />
          </el-form-item>
          <el-form-item label="Description" prop="description">
            <el-input v-model="currentGradeLevel.description" />
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="gradeLevelFormVisible = false">Cancel</el-button>
          <el-button :disabled="submitted" type="primary" @click="handleSubmit">Confirm</el-button>
        </div>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import Resource from '@/api/resource';
import permission from '@/directive/permission';
const gradeLevelResource = new Resource('gradeLevels');
const departmentResource = new Resource('departments');

export default {
  name: 'GradeLevelList',
  directives: { permission },
  data() {
    return {
      list: [],
      deptList: [],
      loading: true,
      gradeLevelFormVisible: false,
      currentGradeLevel: {},
      submitted: false,
      formTitle: '',
    };
  },
  created() {
    this.getList();
    this.getDeptList();
  },
  methods: {
    async getList() {
      this.loading = true;
      const { data } = await gradeLevelResource.list({});
      this.list = data;
      this.loading = false;
    },
    async getDeptList() {
      this.loading = true;
      const { data } = await departmentResource.list({});
      this.deptList = data;
      this.loading = false;
    },
    handleCreate() {
      this.gradeLevelFormVisible = true;
      this.resetForm();
      this.formTitle = 'Create New Grade Level';
    },
    handleSubmit() {
      this.submitted = true;
      if (this.currentGradeLevel.id !== undefined) {
        gradeLevelResource
          .update(this.currentGradeLevel.id, this.currentGradeLevel)
          .then(response => {
            this.$message({
              type: 'success',
              message: 'Grade Level info has been updated successfully',
              duration: 5 * 1000,
            });
            this.getList();
            this.submitted = false;
          })
          .catch(error => {
            console.log(error);
          })
          .finally(() => {
            this.gradeLevelFormVisible = false;
            this.submitted = false;
          });
      } else {
        gradeLevelResource
          .store(this.currentGradeLevel)
          .then(response => {
            this.$message({
              message:
                'New Grade Level ' +
                this.currentGradeLevel.name +
                ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.resetForm();
            this.gradeLevelFormVisible = false;
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
        'This will permanently delete grade level ' + name + '. Continue?',
        'Warning',
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
        }
      )
        .then(() => {
          gradeLevelResource.destroy(id).then(response => {
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
      this.formTitle = 'Edit Grade Level ' + name;
      this.currentGradeLevel = this.list.find(
        gradeLevel => gradeLevel.id === id
      );
      this.gradeLevelFormVisible = true;
    },
    resetForm() {
      this.currentGradeLevel = {
        name: '',
        description: '',
      };
    },
  },
};
</script>

