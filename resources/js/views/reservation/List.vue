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
      <el-select
        v-model="listQuery.school_year_id"
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
      <el-table-column align="center" label="SY" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.school_year.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Name" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.student.last_name }}, {{ scope.row.student.first_name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Grade Level" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.grade_level.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Section" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.section.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Status" width="150">
        <template slot-scope="scope">
          <span>{{ scope.row.status }}</span>
        </template>
      </el-table-column>

      <el-table-column
        v-permission="['manage reservation']"
        align="center"
        label="Actions"
        width="200"
      >
        <template slot-scope="scope">
          <el-button
            v-permission="['manage reservation']"
            type="primary"
            size="small"
            icon="el-icon-edit"
            @click="handleEdit(scope.row.id, scope.row.student.last_name + ', ' + scope.row.student.first_name)"
            >Edit</el-button
          >
          <el-button
            v-permission="['manage reservation']"
            type="danger"
            size="small"
            icon="el-icon-delete"
            @click="handleDelete(scope.row.id, scope.row.student.last_name + ', ' + scope.row.student.first_name)"
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
          v-if="!studentValid"
          ref="reservationSearchForm"
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
            :reservation = true
            @save-student = "proceedReservation"
          />
        </el-form>

        <el-form
          v-if="studentValid"
          ref="reservationForm"
          :rules="rule1"
          :model="currentReservation"
          label-position="left"
          label-width="150px"
          style="max-width: 500px"
        >
          <el-form-item label="Student No" prop="sudent_id">
            <el-input v-model="currentReservation.student_no" :readonly="studentValid" />
          </el-form-item>
          <el-form-item label="Student Name" prop="name">
            <el-input v-model="currentReservation.name" :readonly="studentValid" />
          </el-form-item>
          <el-form-item label="Student Type" prop="student_type">
            <el-input v-model="currentReservation.student_type" :readonly="studentValid" />
          </el-form-item>
          <el-form-item label="School Year" prop="school_year_id">
            <el-select
              v-model="currentReservation.school_year_id"
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
          <el-form-item label="Grade Level" prop="grade_level_id">
            <el-select
              v-model="currentReservation.grade_level_id"
              class="filter-item"
              placeholder="Please Grade Level"
              @change="filterSection"
            >
              <el-option
                v-for="item in gradeList"
                :key="item.id"
                :label="item.name | uppercaseFirst"
                :value="item.id"
              />
            </el-select>
          </el-form-item>
          <el-form-item label="Section" prop="section_id">
            <el-select
              v-model="currentReservation.section_id"
              class="filter-item"
              placeholder="Please Section"
            >
              <el-option
                v-for="item in filteredSectionList"
                :key="item.id"
                :label="item.name | uppercaseFirst"
                :value="item.id"
              />
            </el-select>
          </el-form-item>
          <el-form-item label="Reservation Fee" prop="student_type">
            <el-input v-model="currentReservation.reservation_fee" :readonly="studentValid" />
          </el-form-item>
          <el-form-item label="Receipt">
            <dropzone id="myVueDropzone" url="/api/reservations/upload-receipt" @dropzone-removedFile="dropzoneR" @dropzone-success="dropzoneS" />
          </el-form-item>
          <el-form-item>
            <el-button @click="reservationFormVisible = false">Cancel</el-button>
            <el-button :disabled="submitted" type="primary" @click="handleSubmit">
              Confirm</el-button
            >
            </el-form-item>
        </el-form>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import Resource from '@/api/resource';
import permission from '@/directive/permission';
import Pagination from '@/components/Pagination'; // Secondary package based on el-
import StudentActivity from '../students/components/StudentActivity';
import Dropzone from '@/components/Dropzone';

const reservationResource = new Resource('reservation');
const gradeLevelResource = new Resource('gradeLevels');
const departmentResource = new Resource('departments');
const sectionResource = new Resource('sections');
const studentResource = new Resource('students');
const schoolYearResource = new Resource('schoolYear');

export default {
  name: 'ReservationList',
  components: { Pagination, StudentActivity, Dropzone },
  directives: { permission },
  data() {
    return {
      list: [],
      listQuery: {
        page: 1,
        limit: 20,
        title: '',
        school_year_id: '',
      },
      studentQuery: {
        id: '',
        birthdate: '',
      },
      total: 0,
      schoolYearList: [],
      deptList: [],
      gradeList: [],
      sectionList: [],
      filteredSectionList: [],
      loading: true,
      reservationFormVisible: false,
      reservationForm: false,
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
      rule1: {
        school_year_id: [
          {
            required: true,
            message: 'Please select school year',
            trigger: 'blur',
          },
          {
            required: true,
            message: 'Please input school year',
            trigger: 'change',
          },
        ],
        section_id: [
          {
            required: true,
            message: 'Please select section',
            trigger: 'blur',
          },
          {
            required: true,
            message: 'Please input section',
            trigger: 'change',
          },
        ],
        grade_level_id: [
          {
            required: true,
            message: 'Please select grade',
            trigger: 'blur',
          },
          {
            required: true,
            message: 'Please input grade',
            trigger: 'change',
          },
        ],
      },
    };
  },
  created() {
    this.getList();
    this.getDeptList();
    this.getGradeList();
    this.getSectionList();
    this.getSchoolYearList();
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
      this.filteredSectionList = data.data;
      this.loading = false;
    },
    async getSchoolYearList() {
      this.loading = true;
      const { data } = await schoolYearResource.list({});
      this.schoolYearList = data.data;
      this.loading = false;
    },
    async getStudentDetails(){
      this.loading = true;
      const { data } = await studentResource.list(this.studentQuery);
      this.student = data[0];
      // student data does not exist
      if (this.student.length === 0){
        this.studentValid = false;
      } else {
        this.resetForm();
        this.studentValid = true;
        this.formTitle = 'Create Reservation for ' + this.student.first_name + ' ' + this.student.last_name;
        this.currentReservation.student_id = this.student.id;
        this.currentReservation.student_no = this.student.student_no;
        this.currentReservation.name = this.student.first_name + ' ' + this.student.last_name;
        this.currentReservation.student_type = 'Old Student';
        this.currentReservation.reservation_fee = 'PHP 1,000';
        this.currentReservation.reservation_amount = '1000';
      }
    },
    filterSection(){
      this.filteredSectionList = [];
      this.filteredSectionList = this.sectionList.filter(this.mapSection);
    },
    mapSection(item, index, arr){
      if (parseInt(item.grade_level_id) === parseInt(this.currentReservation.grade_level_id)){
        return item;
      }
    },
    handleCreate() {
      this.reservationFormVisible = true;
      this.resetForm();
      this.formTitle = 'Create Reservation';
    },
    handleSubmit() {
      this.$refs['reservationForm'].validate((valid) => {
        if (!valid) {
          return false;
        } else {
          this.submitted = true;
          alert(this.currentReservation.id);
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
        }
      });
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
      var data = this.list.find(
        (reservation) => reservation.id === id
      );
      console.log(this.currentReservation);
      this.currentReservation.id = data.id;
      this.currentReservation.student_id = data.student.id;
      this.currentReservation.student_no = data.student.student_no;
      this.currentReservation.name = data.student.first_name + ' ' + data.student.last_name;
      this.currentReservation.student_type = data.student_type === '0' ? 'Old Student' : 'New';
      this.currentReservation.reservation_fee = data.reservation_amount;
      this.currentReservation.reservation_amount = data.reservation_amount;
      this.currentReservation.school_year_id = data.school_year_id;
      this.currentReservation.grade_level_id = data.grade_level_id;
      this.filterSection();
      this.currentReservation.section_id = data.section_id;
      this.reservationFormVisible = true;
      this.studentValid = true;
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
    dropzoneS(file, response) {
      this.currentReservation.payment_receipt = file.xhr.responseText;
      // this.$message({ message: 'Upload success', type: 'success' });
    },
    dropzoneR(file) {
      this.currentReservation.payment_receipt = '';
      // this.$message({ message: 'Delete success', type: 'success' });
    },
    proceedReservation(data){
      alert();
      console.log(data);
      if (data.length === 0){
        this.studentValid = false;
      } else {
        this.student = data;
        this.resetForm();
        this.studentValid = true;
        this.formTitle = 'Create Reservation for ' + this.student.first_name + ' ' + this.student.last_name;
        this.currentReservation.student_id = this.student.id;
        this.currentReservation.student_no = this.student.student_no;
        this.currentReservation.name = this.student.first_name + ' ' + this.student.last_name;
        this.currentReservation.student_type = 'New Student';
        this.currentReservation.reservation_fee = 'PHP 2,000';
        this.currentReservation.reservation_amount = '2000';
      }
    },
  },
};
</script>

