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
      <el-button
        v-permission="['manage studentpayment']"
        class="filter-item"
        type="primary"
        icon="el-icon-plus"
        @click="searchStudentPayment();"
      >{{ $t('table.add') }}</el-button>
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
          <span>{{ scope.row.student.student_no }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Name">
        <template slot-scope="scope">
          <span>{{ scope.row.student.last_name }},{{ scope.row.student.first_name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="School Year">
        <template slot-scope="scope">
          <span>{{ scope.row.school_year.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Month">
        <template slot-scope="scope">
          <span>{{ scope.row.school_year.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Actions" width="200">
        <template slot-scope="scope">
          <el-button
            v-permission="['manage studentpayment']"
            type="success"
            size="small"
            icon="el-icon-view"
            title="View"
            @click="handleDelete(scope.row.id, scope.row.name);"
          />
          <el-button
            v-permission="['manage studentpayment']"
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

    <!--  DIALOG for Add and EDIT -->
    <el-dialog
      v-permission="['manage studentpayment']"
      :title="formTitle"
      :visible.sync="newPaymentFormVisible"
    >
      <div class="form-container">
        <el-form
          v-if="!studentValid"
          ref="reservationSearchForm"
          :model="searchStudentPaymentForm"
          label-position="left"
          label-width="150px"
          style="max-width: 500px"
        >
          <el-form-item
            label="Student No"
            prop="student_no"
          >
            <el-input v-model="searchStudentPaymentForm.student_no" />
          </el-form-item>
          <el-form-item
            label="School Year"
            prop="school_year"
          >
            <el-select
              v-model="searchStudentPaymentForm.school_year_id"
              class="filter-item"
              placeholder="Please School Year"
            >
              <el-option
                v-for="item in schoolYearList"
                :key="item.id"
                :label="item.name | uppercaseFirst"
                :value="item.id"
              />
            </el-select>
          </el-form-item>
          <el-form-item>
            <el-button @click="onCancelSearch">Reset</el-button>
            <el-button type="primary" @click="getStudentPaymentDetails">
              Search Student
            </el-button>
          </el-form-item>
        </el-form>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import Resource from '@/api/resource';
import permission from '@/directive/permission';
import waves from '@/directive/waves';
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination

const studentPaymentResource = new Resource('studentpayment');
const schoolYearResource = new Resource('schoolYear');
const studentEnrollment = new Resource('enrollment');

export default {
  name: 'StudentPaymentList',
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
      newPaymentFormVisible: false,
      currentStudent: {},
      submitted: false,
      formTitle: '',
      downloading: false,
      /* Dialog */
      activeActivity: 'first',
      updating: false,
      studentValid: false,
      searchStudentPaymentForm: {
        student_no: '',
        school_year: '',
      },
      schoolYearList: [],
    };
  },
  created() {
    this.getList();
    this.getSchoolYearList();
  },
  methods: {
    async getList() {
      const { limit, page } = this.listQuery;
      this.loading = true;
      const { data } = await studentPaymentResource.list(this.listQuery);
      this.list = data.data;
      console.log(this.list);
      this.list.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.total = data.total;
      console.log(this.total);
      this.loading = false;
    },
    async getSchoolYearList() {
      this.loading = true;
      const { data } = await schoolYearResource.list({ all: 'all' });
      this.schoolYearList = data;
      this.loading = false;
    },
    async searchStudentEnrollment(){
      this.loading = true;
      const { data } = await studentEnrollment.list({ student_no: this.searchStudentPaymentForm.student_no, school_year_id: this.searchStudentPaymentForm.school_year_id });
      console.log(data);
      if (data.length === 0) {
        this.$message({
          type: 'warning',
          message: 'Student is not enrolled',
          duration: 5 * 1000,
        });
      } else {
        this.newPaymentFormVisible = false;
        var enrollment_id = data[0].id;
        this.$router.push(`new/${enrollment_id}`);
      }
    },
    onCancelSearch(){
      this.newPaymentFormVisible = false;
    },

    searchStudentPayment(){
      this.newPaymentFormVisible = true;
      this.formTitle = 'Search Student Payment';
    },
    getStudentPaymentDetails(){
      this.searchStudentEnrollment();
    },
    handleCreate() {
      this.feeFormVisible = true;
      this.resetForm();
      this.formTitle = 'Create New Student';
    },
    handleSubmit() {
      this.submitted = true;
      if (this.currentStudent.id !== undefined) {
        studentPaymentResource
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
        studentPaymentResource
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
          studentPaymentResource.destroy(id).then((response) => {
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
