<template>
  <div class="app-container">
    <div class="filter-container">
      <el-button
        v-permission="['manage section']"
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
          <span>{{ scope.row.grade_level.name }}</span>
        </template>
      </el-table-column>

      <el-table-column v-permission="['manage section']" align="center" label="Actions" width="200">
        <template slot-scope="scope">
          <el-button
            v-permission="['manage section']"
            type="primary"
            size="small"
            icon="el-icon-edit"
            @click="handleEdit(scope.row.id, scope.row.name)"
          >Edit</el-button>
          <el-button
            v-permission="['manage section']"
            type="danger"
            size="small"
            icon="el-icon-delete"
            @click="handleDelete(scope.row.id, scope.row.name);"
          >Delete</el-button>
        </template>
      </el-table-column>
    </el-table>

    <el-dialog
      v-permission="['manage section']"
      :title="formTitle"
      :visible.sync="sectionFormVisible"
    >
      <div class="form-container">
        <el-form
          ref="gradeLevelForm"
          :model="currentSection"
          label-position="left"
          label-width="150px"
          style="max-width: 500px"
        >
          <el-form-item :label="$t('table.gradeLevel')" prop="grade_level_id">
            <el-select
              v-model="currentSection.grade_level_id"
              class="filter-item"
              placeholder="Please select grade level"
            >
              <el-option
                v-for="item in gradeLevelList"
                :key="item.id"
                :label="item.name | uppercaseFirst"
                :value="item.id"
              />
            </el-select>
          </el-form-item>
          <el-form-item label="Name" prop="name">
            <el-input v-model="currentSection.name" />
          </el-form-item>
          <el-form-item label="Description" prop="description">
            <el-input v-model="currentSection.description" />
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="sectionFormVisible = false">Cancel</el-button>
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
const sectionResource = new Resource('sections');

export default {
  name: 'SectionList',
  directives: { permission },
  data() {
    return {
      list: [],
      gradeLevelList: [],
      loading: true,
      sectionFormVisible: false,
      currentSection: {},
      submitted: false,
      formTitle: '',
    };
  },
  created() {
    this.getList();
    this.getGradeLevelList();
  },
  methods: {
    async getList() {
      this.loading = true;
      const { data } = await sectionResource.list({});
      console.log(data);
      this.list = data;
      this.loading = false;
    },
    async getGradeLevelList() {
      this.loading = true;
      const { data } = await gradeLevelResource.list({});
      this.gradeLevelList = data;
      this.loading = false;
    },
    handleCreate() {
      this.sectionFormVisible = true;
      this.resetForm();
      this.formTitle = 'Create New Grade Level';
    },
    handleSubmit() {
      this.submitted = true;
      if (this.currentSection.id !== undefined) {
        sectionResource
          .update(this.currentSection.id, this.currentSection)
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
            this.sectionFormVisible = false;
            this.submitted = false;
          });
      } else {
        sectionResource
          .store(this.currentSection)
          .then(response => {
            this.$message({
              message:
                'New Grade Level ' +
                this.currentSection.name +
                ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.resetForm();
            this.sectionFormVisible = false;
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
          sectionResource.destroy(id).then(response => {
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
      this.currentSection = this.list.find(gradeLevel => gradeLevel.id === id);
      console.log(this.currentSection);
      this.sectionFormVisible = true;
    },
    resetForm() {
      this.currentSection = {
        name: '',
        description: '',
        grade_level_id: '',
      };
    },
  },
};
</script>

