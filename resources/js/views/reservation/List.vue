<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input
        v-model="listQuery.title"
        :placeholder="$t('table.search')"
        style="width: 200px"
        class="filter-item"
        @keyup.enter.native="getList"
      />
      <el-button
        class="filter-item"
        type="primary"
        icon="el-icon-search"
        @click="getList">
        {{ $t('table.search') }}
      </el-button>
      <el-button
        v-permission="['manage reservation']"
        class="filter-item"
        type="primary"
        icon="el-icon-plus"
        @click="handleCreate">{{ $t('table.add') }}</el-button>
    </div>

    <el-table v-loading="loading" :data="list" border fit highlight-current-row>
      <el-table-column align="center" label="ID" width="100">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="SY" width="100">
        <template slot-scope="scope">
          <span>{{ scope.row.year }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Name" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Grade Level" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.start_month }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Status" width="150">
        <template slot-scope="scope">
          <span>{{ scope.row.status == 1 ? 'Active' : 'Inactive' }}</span>
        </template>
      </el-table-column>

      <el-table-column
        v-permission="['manage reservation']"
        align="center"
        label="Actions"
        width="200"
      >
        <template slot-scope="scope">
          <!--  <el-button
            v-permission="['manage reservation']"
            type="success"
            size="small"
            icon="el-icon-view"
            @click="handleView(scope.row.id, scope.row.name)"
            >View</el-button
          > -->
          <el-button
            v-permission="['manage reservation']"
            type="primary"
            size="small"
            icon="el-icon-edit"
            @click="handleEdit(scope.row.id, scope.row.name)"
            >Edit</el-button
          >
          <el-button
            v-permission="['manage reservation']"
            type="danger"
            size="small"
            icon="el-icon-delete"
            @click="handleDelete(scope.row.id, scope.row.name)"
          >
            Delete
          </el-button>
        </template>
      </el-table-column>
    </el-table>

    <pagination
      v-show="total > 0"
      :total="total"
      :page.sync="listQuery.page"
      :limit.sync="listQuery.limit"
      @pagination="getList"
    />
    <!--  DIALOG for Add and EDIT -->
    <el-dialog
      v-permission="['manage reservation']"
      :title="formTitle"
      :visible.sync="reservationFormVisible"
    >
      <div class="form-container">
        <el-form
          ref="schoolYearForm"
          :model="currentReservation"
          label-position="left"
          label-width="150px"
          style="max-width: 500px"
        >
          <el-form-item label="Student Type">
            <el-radio-group v-model="currentReservation.type">
              <el-radio :label="0">Old Student</el-radio>
              <el-radio :label="1">New Student</el-radio>
            </el-radio-group>
          </el-form-item>
          <el-form-item v-if="currentReservation.type == 0" label="Student No" prop="name">
            <el-input v-model="studentQuery.id" />
          </el-form-item>
          <el-form-item v-if="currentReservation.type == 0" label="Birthdate" prop="birthdate">
            <el-date-picker
              v-model="studentQuery.birthdate"
              type="date"
              placeholder="Select Birtdate"
              style="width: 100%"
            />
          </el-form-item>
          <el-form-item v-if="currentReservation.type == 0">
              <el-button @click="onCancelSearch">Reset</el-button>
              <el-button type="primary" @click="getStudentDetails">Search Student</el-button>
            </el-form-item>
          <student-activity
            v-if="currentReservation.type == 1"
          />
        </el-form>
        <div  v-if="studentValid" slot="footer" class="dialog-footer">
          <el-button @click="reservationFormVisible = false">Cancel</el-button>
          <el-button :disabled="submitted" type="primary" @click="handleSubmit">
            Confirm</el-button
          >
        </div>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import Resource from '@/api/resource';
import permission from '@/directive/permission';
import Pagination from '@/components/Pagination'; // Secondary package based on el-
import StudentActivity from '../students/components/StudentActivity';

const reservationResource = new Resource('reservation');
const gradeLevelResource = new Resource('gradeLevels');
const departmentResource = new Resource('departments');
const sectionResource = new Resource('sections');
const studentResource = new Resource('students');

export default {
  name: 'ReservationList',
  components: { Pagination, StudentActivity },
  directives: { permission },
  data() {
    return {
      list: [],
      listQuery: {
        page: 1,
        limit: 20,
        title: '',
      },
      studentQuery: {
        id: '',
        birthdate: '',
      },
      total: 0,
      deptList: [],
      gradeList: [],
      sectionList: [],
      loading: true,
      reservationFormVisible: false,
      schoolYearDetails: false,
      currentReservation: {
        student_id: '',
        school_year_id: '',
        department_id: '',
        grade_level_id: '',
        section_id: '',
        reservation_amount: '',
        payment_receipt: '',
        type: 0,
      },
      student: [],
      submitted: false,
      studentValid: false,
      formTitle: '',
    };
  },
  created() {
    // this.getList();
    this.getDeptList();
    this.getGradeList();
    this.getSectionList();
    this.resetForm();
  },
  methods: {
    async getList() {
      this.loading = true;
      const { data } = await reservationResource.list(this.listQuery);
      this.list = data.data;
      this.total = data.total;
      this.loading = false;
    },
    async getDeptList() {
      this.loading = true;
      const { data } = await departmentResource.list({});
      this.deptList = data.data;
      this.loading = false;
    },
    async getGradeList() {
      this.loading = true;
      const { data } = await gradeLevelResource.list({});
      this.gradeList = data.data;
      this.loading = false;
    },
    async getSectionList() {
      this.loading = true;
      const { data } = await sectionResource.list({});
      this.sectionList = data.data;
      this.loading = false;
    },
    async getStudentDetails(){
      this.loading = true;
      const { data } = await studentResource.list(this.studentQuery);
      console.log(data);
      this.student = data.data;
    },
    handleCreate() {
      this.reservationFormVisible = true;
      this.resetForm();
      this.formTitle = 'Create Reservation';
    },
    handleSubmit() {
      this.submitted = true;
      if (this.currentReservation.id !== undefined) {
        reservationResource
          .update(this.currentReservation.id, this.currentReservation)
          .then((response) => {
            this.$message({
              type: 'success',
              message: 'Reservation info has been updated successfully',
              duration: 5 * 1000,
            });
            this.getList();
            this.submitted = false;
          })
          .catch((error) => {
            console.log(error);
          })
          .finally(() => {
            this.reservationFormVisible = false;
            this.submitted = false;
          });
      } else {
        console.log(this.currentReservation);
        reservationResource
          .store(this.currentReservation)
          .then((response) => {
            this.$message({
              message:
                'New Reservation for: ' +
                this.currentReservation.name +
                ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.resetForm();
            this.reservationFormVisible = false;
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
        'This will permanently delete reservation ' + name + '. Continue?',
        'Warning',
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
        }
      )
        .then(() => {
          reservationResource.destroy(id).then((response) => {
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
      this.formTitle = 'Edit Reservation ' + name;
      this.currentReservation = this.list.find(
        (schoolYear) => schoolYear.id === id
      );
      console.log(this.currentReservation);
      this.reservationFormVisible = true;
    },
    resetForm() {
      this.currentReservation = {
        student_id: '',
        school_year_id: '',
        department_id: '',
        grade_level_id: '',
        section_id: '',
        reservation_amount: '',
        payment_receipt: '',
        type: 0,
      };
      this.submitted = false;
    },
    onCancelSearch(){
      this.studentQuery = {
        id: '',
        birthdate: '',
      };
    },
  },
};
</script>

