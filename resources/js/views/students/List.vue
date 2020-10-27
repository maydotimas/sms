<template>
  <div class="app-container">
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
      <router-link :to="'new/'">
        <el-button
          v-permission="['manage students']"
          class="filter-item"
          type="primary"
          icon="el-icon-plus"
        >{{ $t('table.add') }}</el-button>
      </router-link>
      <el-button
        v-waves
        :loading="downloading"
        class="filter-item"
        type="primary"
        icon="el-icon-download"
        @click="handleDownload"
      >{{ $t('table.export') }}</el-button>
      <el-button
        v-waves
        :loading="downloading"
        class="filter-item"
        type="primary"
        icon="el-icon-upload2"
        @click="handleDownload"
      >{{ $t('table.import') }}</el-button>
    </div>
    <el-table v-loading="loading" :data="list" border fit highlight-current-row>
      <el-table-column align="center" label="ID" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.index }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Student No">
        <template slot-scope="scope">
          <span>{{ scope.row.student_no }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="LRN">
        <template slot-scope="scope">
          <span>{{ scope.row.lrn }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Name">
        <template slot-scope="scope">
          <span>{{ scope.row.last_name }},{{ scope.row.first_name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Mobile No">
        <template slot-scope="scope">
          <span>{{ scope.row.mobile }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Actions" width="200">
        <template slot-scope="scope">
          <el-button
            v-permission="['manage students']"
            type="success"
            size="small"
            icon="el-icon-view"
            title="View"
            @click="handledelete(scope.row.id, scope.row.name);"
          />
          <router-link :to="'edit/'+scope.row.id">
            <el-button
              v-permission="['manage students']"
              type="primary"
              size="small"
              icon="el-icon-edit"
              title="Edit"
            />
          </router-link>
          <el-button
            v-permission="['manage students']"
            type="danger"
            size="small"
            icon="el-icon-delete"
            title="Delete"
            @click="handleDelete(scope.row.id, scope.row.name);"
          />
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
  </div>
</template>

<script>
import Resource from '@/api/resource';
import permission from '@/directive/permission';
import waves from '@/directive/waves';
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination

const studentResource = new Resource('students');

export default {
  name: 'MasterList',
  components: { Pagination },
  directives: { permission, waves },
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
      feeFormVisible: false,
      currentStudent: {},
      submitted: false,
      formTitle: '',
      downloading: false,
      /* Dialog */
      activeActivity: 'first',
      updating: false,
    };
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      const { limit, page } = this.listQuery;
      this.loading = true;
      const { data } = await studentResource.list(this.listQuery);
      this.list = data.data;
      this.list.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.total = data.total;
      console.log(this.total);
      this.loading = false;
    },
    handleCreate() {
      this.feeFormVisible = true;
      this.resetForm();
      this.formTitle = 'Create New Student';
    },
    handleSubmit() {
      this.submitted = true;
      if (this.currentStudent.id !== undefined) {
        studentResource
          .update(this.currentStudent.id, this.currentStudent)
          .then((response) => {
            this.$message({
              type: 'success',
              message: 'Student info has been updated successfully',
              duration: 5 * 1000,
            });
            this.getList();
            this.submitted = false;
          })
          .catch((error) => {
            console.log(error);
          })
          .finally(() => {
            this.feeFormVisible = false;
            this.submitted = false;
          });
      } else {
        studentResource
          .store(this.currentStudent)
          .then((response) => {
            this.$message({
              message:
                'New Student ' +
                this.currentStudent.name +
                ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.resetForm();
            this.feeFormVisible = false;
            this.submitted = false;
            this.getList();
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    handleDelete(id, name) {
      this.$confirm(
        'This will permanently delete fee ' + name + '. Continue?',
        'Warning',
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
        }
      )
        .then(() => {
          studentResource.destroy(id).then((response) => {
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
      this.formTitle = 'Edit Student ' + name;
      this.currentStudent = this.list.find((fee) => fee.id === id);
      this.feeFormVisible = true;
    },
    handleDownload() {
      this.downloading = true;
      import('@/vendor/Export2Excel').then((excel) => {
        const tHeader = ['id', 'user_id', 'name', 'email', 'role'];
        const filterVal = ['index', 'id', 'name', 'email', 'role'];
        const data = this.formatJson(filterVal, this.list);
        excel.export_json_to_excel({
          header: tHeader,
          data,
          filename: 'user-list',
        });
        this.downloading = false;
      });
    },
    resetForm() {
      this.currentStudent = {
        name: '',
        description: '',
        tuition: '0',
        misc: '0',
      };
    },

    /* Dialog tab */
    handleClick(tab, event) {
      console.log('Switching tab ', tab, event);
    },
  },
};
</script>

<style lang="scss" scoped>
.edit-input {
  padding-right: 100px;
}
.cancel-btn {
  position: absolute;
  right: 15px;
  top: 10px;
}
.dialog-body {
  padding: 0px 0px;
}
.dialog-footer {
  text-align: left;
  padding-top: 0;
  margin-left: 150px;
}
.app-container {
  flex: 1;
  justify-content: space-between;
  font-size: 14px;
  padding-right: 8px;
  .block {
    float: left;
    min-width: 250px;
  }
  .clear-left {
    clear: left;
  }
}
</style>
