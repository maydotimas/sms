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
        @click="getList"
      >
        {{ $t('table.search') }}
      </el-button>
      <el-button
        v-permission="['manage enrollment']"
        class="filter-item"
        type="primary"
        icon="el-icon-plus"
        @click="handleCreate"
        >{{ $t('table.add') }}</el-button
      >
    </div>

    <el-table v-loading="loading" :data="list" border fit highlight-current-row>
      <el-table-column align="center" label="SY" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.school_year.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Name" width="200">
        <template slot-scope="scope">
          <span
            >{{ scope.row.student.last_name }},
            {{ scope.row.student.first_name }}</span
          >
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
        v-permission="['manage enrollment']"
        align="center"
        label="Actions"
        width="200"
      >
        <template slot-scope="scope">
          <el-button
            v-permission="['manage enrollment']"
            type="primary"
            size="small"
            icon="el-icon-edit"
            @click="
              handleEdit(
                scope.row.id,
                scope.row.student.last_name +
                  ', ' +
                  scope.row.student.first_name
              )
            "
            >Edit</el-button
          >
          <el-button
            v-permission="['manage enrollment']"
            type="danger"
            size="small"
            icon="el-icon-delete"
            @click="
              handleDelete(
                scope.row.id,
                scope.row.student.last_name +
                  ', ' +
                  scope.row.student.first_name
              )
            "
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
      v-permission="['manage enrollment']"
      :title="formTitle"
      :visible.sync="enrollmentFormVisible"
    >
      <div class="form-container">
        <el-form
          v-if="!studentValid"
          ref="reservationSearchForm"
          :model="currentEnrollment"
          label-position="left"
          label-width="150px"
          style="max-width: 500px"
        >
          <el-form-item label="Student Type">
            <el-radio-group v-model="currentEnrollment.type">
              <el-radio :label="0">Old Student</el-radio>
              <el-radio :label="1">New Student</el-radio>
            </el-radio-group>
          </el-form-item>
          <el-form-item
            v-if="currentEnrollment.type == 0"
            label="Student No"
            prop="name"
          >
            <el-input v-model="studentQuery.id" />
          </el-form-item>
          <el-form-item
            v-if="currentEnrollment.type == 0"
            label="Birthdate"
            prop="birthdate"
          >
            <el-date-picker
              v-model="studentQuery.birthdate"
              type="date"
              placeholder="Select Birtdate"
              style="width: 100%"
            />
          </el-form-item>
          <el-form-item v-if="currentEnrollment.type == 0">
            <el-button @click="onCancelSearch">Reset</el-button>
            <el-button type="primary" @click="getStudentDetails"
              >Search Student</el-button
            >
          </el-form-item>
          <student-activity
            v-if="currentEnrollment.type == 1"
            :enrollment="true"
            @save-student="proceedReservation"
          />
        </el-form>

        <el-form
          v-if="studentValid"
          ref="enrollmentForm"
          :rules="rule1"
          :model="currentEnrollment"
          label-position="left"
          label-width="150px"
          style="max-width: 500px"
        >
          <el-form-item label="Student No" prop="student_id">
            <el-input
              v-model="currentEnrollment.student_no"
              :readonly="studentValid"
            />
          </el-form-item>
          <el-form-item label="Student Name" prop="name">
            <el-input
              v-model="currentEnrollment.name"
              :readonly="studentValid"
            />
          </el-form-item>
          <el-form-item label="Student Type" prop="student_type">
            <el-input
              v-model="currentEnrollment.student_type"
              :readonly="studentValid"
            />
          </el-form-item>
          <el-form-item label="School Year">
            <el-input
              v-model="currentEnrollment.schoolYear"
              :readonly="studentValid"
            />
          </el-form-item>
          <el-form-item label="Grade Level" prop="grade_level_id">
            <el-select
              v-model="currentEnrollment.grade_level_id"
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
              v-model="currentEnrollment.section_id"
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
          <el-form-item label="Tuition Fee" prop="sub_fee_id">
            <el-select
              v-model="currentEnrollment.sub_fee_id"
              class="filter-item"
              placeholder="Please Select Tuition"
              @change="computeTuition"
            >
              <el-option
                v-for="item in filteredTuition"
                :key="item.id"
                :label="formatTuition(item) | uppercaseFirst"
                :value="item.id"
              />
            </el-select>
          </el-form-item>
          <el-form-item label="Payment Mode" prop="payment_mode_type_id">
            <el-select
              v-model="currentEnrollment.payment_mode_type_id"
              class="filter-item"
              placeholder="Please Payment Mode"
              @change="computeTuition"
            >
              <el-option
                v-for="item in paymentModeTypeList"
                :key="item.id"
                :label="formatPaymentMode(item) | uppercaseFirst"
                :value="item.id"
              />
            </el-select>
          </el-form-item>
          <el-form-item label="Enrollment Fee" prop="student_type">
            <el-input
              v-model="currentEnrollment.enrollment_fee"
              :readonly="studentValid"
            />
          </el-form-item>
          <el-form-item label="Receipt">
            <dropzone
              id="myVueDropzone"
              url="/api/enrollments/upload-receipt"
              @dropzone-removedFile="dropzoneR"
              @dropzone-success="dropzoneS"
            />
          </el-form-item>
          <el-form-item>
            <el-button @click="enrollmentFormVisible = false">Cancel</el-button>
            <el-button
              :disabled="submitted"
              type="primary"
              @click="handleSubmit"
            >
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

const enrollmentResource = new Resource('enrollment');
const reservationResource = new Resource('enrollment');
const gradeLevelResource = new Resource('gradeLevels');
const departmentResource = new Resource('departments');
const sectionResource = new Resource('sections');
const studentResource = new Resource('students');
const schoolYearResource = new Resource('schoolYear');
const subFeeResource = new Resource('subFees');
const paymentModeTypeResource = new Resource('payment_mode_types');

export default {
  name: 'StudentEnrollment',
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
      /* Lists */
      schoolYearList: [],
      deptList: [],
      gradeList: [],
      sectionList: [],
      filteredSectionList: [],
      filteredTuition: [],
      filteredPaymentMode: [],
      subFeeList: [],
      paymentModeTypeList: [],
      /* Switches */
      loading: true,
      enrollmentFormVisible: false,
      enrollmentForm: false,
      schoolYearDetails: false,
      currentEnrollment: {
        student_id: '',
        school_year_id: '',
        department_id: '',
        grade_level_id: '',
        section_id: '',
        reservation_amount: '',
        payment_receipt: '',
        type: 0,
        sub_fee_id: '',
        payment_mode_type_id: '',
      },
      student: [],
      dept_id: '',
      fees_id: '',
      regular_fee: '',
      misc_fee: '',
      tuition_fee: '',
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
    this.getTuitionFee();
    this.getPaymentMode();
    this.resetForm();
  },
  methods: {
    /* Get data */
    async getList() {
      this.loading = true;
      const { data } = await enrollmentResource.list(this.listQuery);
      this.list = data.data;
      this.total = data.total;
      this.loading = false;
    },
    async getTuitionFee() {
      this.loading = true;
      const { data } = await subFeeResource.list({});
      this.subFeeList = data.data;
      this.filterTuition();
      this.loading = false;
    },
    async getPaymentMode() {
      this.loading = true;
      const { data } = await paymentModeTypeResource.list({});
      this.paymentModeTypeList = data.data;
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
      const { data } = await sectionResource.list({ active: 'true' });
      this.sectionList = data;
      this.filteredSectionList = data;
      this.loading = false;
    },
    async getSchoolYearList() {
      this.loading = true;
      const { data } = await schoolYearResource.list({ active: 'true' });
      this.schoolYearList = data.data;
      this.loading = false;
    },
    async getStudentDetails() {
      const { data } = await studentResource.list(this.studentQuery);
      this.student = data[0];
      if (data.length == 0) return false;
      // student data does not exist
      if (this.student.length === 0) {
        this.studentValid = false;
      } else {
        this.resetForm();
        this.studentValid = true;
        this.formTitle =
          'Create Enrollment for ' +
          this.student.first_name +
          ' ' +
          this.student.last_name;
        this.currentEnrollment.student_id = this.student.id;
        this.currentEnrollment.student_no = this.student.student_no;
        this.currentEnrollment.name =
          this.student.first_name + ' ' + this.student.last_name;
        this.currentEnrollment.schoolYear = this.schoolYearList[0].name;
        this.currentEnrollment.school_year_id = this.schoolYearList[0].id;
        this.currentEnrollment.student_type = 'Old Student';
        this.currentEnrollment.enrollment_fee = 'PHP 1,000';
        this.currentEnrollment.reservation_amount = '1000';
      }
    },
    /* Mapping and filters */
    filterSection() {
      /* Get department ID */
      var dept = this.gradeList.filter(this.mapGrade);
      this.dept_id = dept[0].department_id;
      /* Get fees ID */
      var fees = this.schoolYearList[0].school_year_config.filter(this.mapFees);
      this.fees_id = fees[0].fees_id;
      /* Get available Sections */
      this.filteredSectionList = [];
      this.filteredSectionList = this.sectionList.filter(this.mapSection);
      this.filterTuition();
    },
    mapFees(item, index, arr) {
      if (parseInt(item.department_id) === parseInt(this.dept_id)) {
        return item;
      }
    },
    mapGrade(item, index, arr) {
      if (
        parseInt(item.id) === parseInt(this.currentEnrollment.grade_level_id)
      ) {
        return item;
      }
    },
    mapSection(item, index, arr) {
      if (
        parseInt(item.grade_level_id) ===
        parseInt(this.currentEnrollment.grade_level_id)
      ) {
        return item;
      }
    },
    filterTuition() {
      this.filteredTuition = [];
      this.filteredTuition = this.subFeeList.filter(this.mapTuition);
    },
    getTuition(item, index, arr) {
      if (parseInt(item.id) === parseInt(this.currentEnrollment.sub_fee_id)) {
        return item;
      }
    },
    getAdditional(item, index, arr) {
      if (
        parseInt(item.id) ===
        parseInt(this.currentEnrollment.payment_mode_type_id)
      ) {
        return item;
      }
    },
    mapTuition(item, index, arr) {
      if (parseInt(item.fee_id) === parseInt(this.fees_id)) {
        return item;
      }
    },
    filterPaymentMode() {
      this.filteredPaymentMode = [];
      this.filteredPaymentMode = this.paymentModeTypeList.filter(
        this.mapPaymentMode
      );
    },
    mapPaymentMode(item, index, arr) {
      /* var config = this.schoolYearList[0].school_year_config;
      var fees_id = config[0].fees_id;
      if (parseInt(item.grade_level_id) === parseInt(this.currentEnrollment.grade_level_id)){ */
      return item;
      // }
    },
    /* Form Events */
    handleCreate() {
      this.enrollmentFormVisible = true;
      this.resetForm();
      this.formTitle = 'Create Enrollment';
    },
    handleSubmit() {
      this.$refs['enrollmentForm'].validate((valid) => {
        if (!valid) {
          return false;
        } else {
          this.submitted = true;
          if (this.currentEnrollment.id !== undefined) {
            enrollmentResource
              .update(this.currentEnrollment.id, this.currentEnrollment)
              .then((response) => {
                this.$message({
                  type: 'success',
                  message: 'Enrollment info has been updated successfully',
                  duration: 5 * 1000,
                });
                this.getList();
                this.submitted = false;
              })
              .catch((error) => {
                console.log(error);
              })
              .finally(() => {
                this.enrollmentFormVisible = false;
                this.submitted = false;
              });
          } else {
            enrollmentResource
              .store(this.currentEnrollment)
              .then((response) => {
                this.$message({
                  message:
                    'New Enrollment for: ' +
                    this.currentEnrollment.name +
                    ' has been created successfully.',
                  type: 'success',
                  duration: 5 * 1000,
                });
                this.resetForm();
                this.enrollmentFormVisible = false;
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
        'This will permanently delete enrollment ' + name + '. Continue?',
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
      this.resetForm();
      this.formTitle = 'Edit Enrollment ' + name;
      var data = this.list.find((enrollment) => enrollment.id === id);
      this.currentEnrollment.id = data.id;
      this.currentEnrollment.student_id = data.student.id;
      this.currentEnrollment.student_no = data.student.student_no;
      this.currentEnrollment.name =
        data.student.first_name + ' ' + data.student.last_name;
      this.currentEnrollment.student_type =
        data.student_type === '0' ? 'Old Student' : 'New';
      this.currentEnrollment.school_year_id = data.school_year_id;
      this.currentEnrollment.grade_level_id = data.grade_level_id;
      this.filterSection();
      this.currentEnrollment.section_id = data.section_id;
      this.currentEnrollment.sub_fee_id = data.sub_fee_id;
      this.currentEnrollment.payment_mode_type_id = data.payment_mode_type_id;
      this.currentEnrollment.enrollment_fee = data.enrollment_amount;
      this.currentEnrollment.schoolYear = data.school_year.name;
      this.currentEnrollment.payment_receipt = data.payment_receipt;
      this.enrollmentFormVisible = true;
      this.studentValid = true;
    },
    resetForm() {
      this.currentEnrollment = {
        student_id: '',
        school_year_id: '',
        department_id: '',
        grade_level_id: '',
        section_id: '',
        reservation_amount: '',
        payment_receipt: '',
        type: 0,
        sub_fee_id: '',
        payment_mode_type_id: '',
      };
      this.submitted = false;
    },
    onCancelSearch() {
      this.studentQuery = {
        id: '',
        birthdate: '',
      };
    },
    /* Upload events */
    dropzoneS(file, response) {
      this.currentEnrollment.payment_receipt = file.xhr.responseText;
      // this.$message({ message: 'Upload success', type: 'success' });
    },
    dropzoneR(file) {
      this.currentEnrollment.payment_receipt = '';
      // this.$message({ message: 'Delete success', type: 'success' });
    },
    proceedReservation(data) {
      if (data.length === 0) {
        this.studentValid = false;
      } else {
        this.student = data;
        this.resetForm();
        this.studentValid = true;
        this.formTitle =
          'Create Enrollment for ' +
          this.student.first_name +
          ' ' +
          this.student.last_name;
        this.currentEnrollment.student_id = this.student.id;
        this.currentEnrollment.student_no = this.student.student_no;
        this.currentEnrollment.name =
          this.student.first_name + ' ' + this.student.last_name;
        this.currentEnrollment.student_type = 'New Student';
        this.currentEnrollment.enrollment_fee = 'PHP 2,000';
        this.currentEnrollment.reservation_amount = '2000';
      }
    },
    /* Computations */
    computeTuition(item) {
      var tuition = this.subFeeList.filter(this.getTuition);
      var discount = parseInt(tuition[0].discount);
      var fee = 0;
      console.log(tuition);
      console.log(discount);
      if (discount == 0) {
        fee = parseInt(this.regular_fee) + parseInt(this.misc_fee);
      } else {
        fee =
          parseInt(this.regular_fee) -
          parseInt(this.regular_fee) * parseFloat(discount / 100) +
          parseInt(this.misc_fee);
      }

      var additional = this.paymentModeTypeList.filter(this.getAdditional);
      if (additional.length > 0) {
        var percentage = parseFloat(additional[0].percentage);
        fee = fee + fee * (percentage / 100);
      }
      this.currentEnrollment.enrollment_fee = fee;
    },
    formatTuition(item) {
      var fee = 0;
      if (item.name.toUpperCase() === 'REGULAR') {
        this.regular_fee = item.tuition;
        this.misc_fee = item.misc;
        fee = parseInt(this.regular_fee) + parseInt(this.misc_fee);
        return item.name + '@' + fee;
      } else {
        fee =
          parseInt(this.regular_fee) -
          parseInt(this.regular_fee) * parseFloat(item.discount / 100) +
          parseInt(this.misc_fee);
        return item.name + '@' + fee + '(less ' + item.discount + '%)';
      }
    },
    formatPaymentMode(item) {
      if (item.percentage === '0') {
        return item.name + ' [' + item.payable_in + ' time payment]';
      } else {
        return (
          item.name +
          ' [' +
          item.payable_in +
          ' gives @ ' +
          item.percentage +
          '%]'
        );
      }
    },
  },
};
</script>

