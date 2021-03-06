<template>
  <div class="app-container">
    Test
    <div class="filter-container">
      <el-input
        v-model="listQuery.title"
        :placeholder="$t('table.search')"
        style="width: 200px"
        class="filter-item"
        @keyup.enter.native="getList"
      />
      <el-button class="filter-item" type="primary" icon="el-icon-search" @click="getList">
        {{ $t('table.search') }}
      </el-button>
      <el-button v-permission="['manage schoolyear']" class="filter-item" type="primary" icon="el-icon-plus" @click="handleCreate">
        {{ $t('table.add') }}
      </el-button>
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

      <el-table-column align="center" label="Year" width="100">
        <template slot-scope="scope">
          <span>{{ scope.row.year }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Start Month" width="100">
        <template slot-scope="scope">
          <span>{{ scope.row.start_month }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="End Month" width="100">
        <template slot-scope="scope">
          <span>{{ scope.row.end_month }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Is Locked" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.is_locked }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Status" width="100">
        <template slot-scope="scope">
          <span>{{ scope.row.status == 1 ? 'Active' : 'Inactive' }}</span>
        </template>
      </el-table-column>

      <el-table-column
        v-permission="['manage schoolyear']"
        align="center"
        label="Actions"
        width="450"
      >
        <template slot-scope="scope">
          <!--  <el-button
            v-permission="['manage schoolyear']"
            type="success"
            size="small"
            icon="el-icon-view"
            @click="handleView(scope.row.id, scope.row.name)"
            >View</el-button
          > -->
          <el-button v-if="scope.row.is_locked == 'NO'" v-permission="['manage schoolyear']" type="warning" size="small" icon="el-icon-lock" @click="handleLock(scope.row.id, scope.row.name, 'lock')">
            Lock
          </el-button>
          <el-button v-if="scope.row.is_locked == 'YES'" v-permission="['manage schoolyear']" type="success" size="small" icon="el-icon-key" @click="handleLock(scope.row.id, scope.row.name, 'unlock')">
            Unlock
          </el-button>
          <el-button v-if="scope.row.status == 0" v-permission="['manage schoolyear']" type="success" size="small" @click="handleActivate(scope.row.id, scope.row.name, 'activate')">
            Activate
          </el-button>
          <el-button v-if="scope.row.status == 1" v-permission="['manage schoolyear']" type="info" size="small" @click="handleActivate(scope.row.id, scope.row.name, 'deactivate')">
            Deactivate
          </el-button>
          <el-button v-permission="['manage schoolyear']" type="primary" size="small" icon="el-icon-edit" @click="handleEdit(scope.row.id, scope.row.name)">
            Edit
          </el-button>
          <el-button v-permission="['manage schoolyear']" type="danger" size="small" icon="el-icon-delete" @click="handleDelete(scope.row.id, scope.row.name)">
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
      v-permission="['manage schoolyear']"
      :title="formTitle"
      :visible.sync="schoolYearFormVisible"
    >
      <div class="form-container">
        <el-form
          ref="schoolYearForm"
          :model="currentSchoolYear"
          label-position="left"
          label-width="150px"
          style="max-width: 500px"
        >
          <el-form-item label="Name" prop="name">
            <el-input v-model="currentSchoolYear.name" />
          </el-form-item>
          <el-form-item label="Year" prop="year">
            <el-select
              v-model="currentSchoolYear.year"
              class="filter-item"
              placeholder="Please select school year"
            >
              <el-option
                v-for="item in yearList"
                :key="item"
                :label="item"
                :value="item"
              />
            </el-select>
          </el-form-item>
          <el-form-item label="Start Month" prop="start_month">
            <el-select
              v-model="currentSchoolYear.start_month"
              class="filter-item"
              placeholder="Please select start month"
            >
              <el-option
                v-for="item in monthList"
                :key="item"
                :label="item"
                :value="item"
              />
            </el-select>
          </el-form-item>
          <el-form-item label="End Month" prop="end_month">
            <el-select
              v-model="currentSchoolYear.end_month"
              class="filter-item"
              placeholder="Please select end month"
            >
              <el-option
                v-for="item in monthList"
                :key="item"
                :label="item"
                :value="item"
              />
            </el-select>
          </el-form-item>
          <el-form-item label="Status" prop="status">
            <el-select
              v-model="currentSchoolYear.status"
              class="filter-item"
              placeholder="Please select status"
            >
              <el-option label="Inactive" value="0" />
              <el-option label="Active" value="1" />
            </el-select>
          </el-form-item>
          <el-form-item label="Payment Mode" prop="payment_mode">
            <el-select
              v-model="currentSchoolYear.payment_mode_id"
              class="filter-item"
              placeholder="Please select payment mode"
            >
              <el-option
                v-for="item in paymentModeList"
                :key="item.id"
                :label="item.name | uppercaseFirst"
                :value="item.id"
              />
            </el-select>
          </el-form-item>
          <div v-for="department in deptList" :key="department.id">
            <el-form-item :label="department.name" prop="department_id">
              <el-select
                v-model="currentSchoolYear.fees[department.id]"
                class="filter-item"
                placeholder="Please select tuition fee"
              >
                <el-option
                  v-for="item in feeList"
                  :key="item.id"
                  :label="item.name | uppercaseFirst"
                  :value="item.id"
                />
              </el-select>
            </el-form-item>
          </div>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="schoolYearFormVisible = false">Cancel</el-button>
          <el-button :disabled="submitted" type="primary" @click="handleSubmit">
            Confirm
          </el-button>
        </div>
      </div>
    </el-dialog>
    <!--  DIALOG for View Details -->
    <el-dialog
      v-permission="['manage schoolyear']"
      :title="formTitle"
      :visible.sync="schoolYearDetails"
    >
      <div class="form-container">
        <el-form
          ref="schoolYearForm"
          :model="currentSchoolYear"
          label-position="left"
          label-width="150px"
          style="max-width: 500px"
        >
          <el-form-item label="Name" prop="name">
            <el-input v-model="currentSchoolYear.name" />
          </el-form-item>
          <el-form-item label="Year" prop="year">
            <el-input v-model="currentSchoolYear.year" />
          </el-form-item>
          <el-form-item label="Start Month" prop="start_month">
            <el-input v-model="currentSchoolYear.start_month" />
          </el-form-item>
          <el-form-item label="End Month" prop="end_month">
            <el-input v-model="currentSchoolYear.end_month" />
          </el-form-item>
          <el-form-item label="Status" prop="status">
            <el-input :value="getStatus(currentSchoolYear.status)" />
          </el-form-item>
          <div v-for="department in deptList" :key="department.id">
            <el-form-item :label="department.name + department.id" prop="department_id">
              <el-select
                v-model="currentSchoolYear.fees[department.id]"
                class="filter-item"
                placeholder="Please select payment config"
              >
                <el-option
                  v-for="item in feeList"
                  :key="item.id"
                  :label="item.name | uppercaseFirst"
                  :value="item.id"
                />
              </el-select>
            </el-form-item>
          </div>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="schoolYearDetails = false">Cancel</el-button>
          <el-button type="primary" @click="schoolYearDetails = false">
            Confirm
          </el-button>
        </div>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import Resource from '@/api/resource';
import permission from '@/directive/permission';
import Pagination from '@/components/Pagination'; // Secondary package based on el-

const schoolYearResource = new Resource('schoolYear');
const feeResource = new Resource('fees');
const departmentResource = new Resource('departments');
const paymentModeResource = new Resource('payment_modes');

export default {
  name: 'SchoolYearList',
  components: { Pagination },
  directives: { permission },
  data() {
    return {
      list: [],
      listQuery: {
        page: 1,
        limit: 20,
        title: '',
      },
      total: 0,
      yearList: ['2020', '2021', '2022', '2023', '2024'],
      monthList: [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December',
      ],
      deptList: [],
      feeList: [],
      paymentModeList: [],
      departments: [],
      fees: [],
      loading: true,
      schoolYearFormVisible: false,
      schoolYearDetails: false,
      currentSchoolYear: {},
      currentSchoolYearView: {},
      currentSchoolYearEdit: {},
      submitted: false,
      formTitle: '',
      regularFee: '',
    };
  },
  created() {
    this.getList();
    this.getDeptList();
    this.getFeeList();
    this.getPaymentModeList();
    this.resetForm();
  },
  methods: {
    async getList() {
      this.loading = true;
      const { data } = await schoolYearResource.list(this.listQuery);
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
    async getFeeList() {
      this.loading = true;
      const { data } = await feeResource.list({});
      this.feeList = data.data;
      this.loading = false;
    },
    async getPaymentModeList() {
      this.loading = true;
      const { data } = await paymentModeResource.list({});
      this.paymentModeList = data.data;
      this.loading = false;
    },
    checkRegular(subfee){
      return subfee.type === 'REGULAR';
    },
    handleView(id, name) {
      this.schoolYearDetails = true;
      this.formTitle = 'View Details for ' + name;
      this.currentSchoolYearView = this.list.find(
        (schoolYear) => schoolYear.id === id
      );

      this.resetForm();
      this.currentSchoolYear = {
        id: this.currentSchoolYearView.id,
        name: this.currentSchoolYearView.name,
        year: this.currentSchoolYearView.year,
        start_month: this.currentSchoolYearView.start_month,
        end_month: this.currentSchoolYearView.end_month,
        status: this.currentSchoolYearView.status === '1' ? 'Active' : 'Inactive',
        fees: [],
      };
      this.currentSchoolYearView.school_year_config.forEach(this.mapDeptFee);
    },
    mapDeptFee(item, index, arr){
      this.currentSchoolYear.fees[item.department_id] = item.fee_id;
    },
    handleCreate() {
      this.schoolYearFormVisible = true;
      this.resetForm();
      this.formTitle = 'Create New School Year';
    },
    handleSubmit() {
      this.submitted = true;
      if (this.currentSchoolYear.id !== undefined && this.currentSchoolYear.id !== '') {
        schoolYearResource
          .update(this.currentSchoolYear.id, this.currentSchoolYear)
          .then((response) => {
            this.$message({
              type: 'success',
              message: 'School Year info has been updated successfully',
              duration: 5 * 1000,
            });
            this.getList();
            this.submitted = false;
          })
          .catch((error) => {
            console.log(error);
          })
          .finally(() => {
            this.schoolYearFormVisible = false;
            this.submitted = false;
          });
      } else {
        console.log(this.currentSchoolYear);
        schoolYearResource
          .store(this.currentSchoolYear)
          .then((response) => {
            this.$message({
              message:
                'New School Year ' +
                this.currentSchoolYear.name +
                ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.resetForm();
            this.schoolYearFormVisible = false;
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
        'This will permanently delete school year ' + name + '. Continue?',
        'Warning',
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
        }
      )
        .then(() => {
          schoolYearResource.destroy(id).then((response) => {
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
    handleLock(id, name, mode) {
      this.$confirm(
        'This will ' + mode + ' school year ' + name + '. Continue?',
        'Warning',
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
        }
      )
        .then(() => {
          schoolYearResource
            .update(id, { 'is_locked': mode })
            .then((response) => {
              this.$message({
                type: 'success',
                message: 'School Year info has been updated successfully',
                duration: 5 * 1000,
              });
              this.getList();
              this.submitted = false;
            })
            .catch((error) => {
              console.log(error);
            })
            .finally(() => {
              this.getList();
              this.schoolYearFormVisible = false;
              this.submitted = false;
            });
        })
        .catch(() => {
          this.$message({
            type: 'info',
            message: 'Update canceled',
          });
        });
    },
    handleActivate(id, name, mode) {
      var msg = '';

      if (mode === 'activate'){
        msg = 'This will ' + mode + ' school year ' + name + ' and deactivate other school years. Continue?';
      } else {
        msg = 'This will ' + mode + ' school year ' + name + '. Continue?';
      }

      this.$confirm(
        msg,
        'Warning',
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
        }
      )
        .then(() => {
          schoolYearResource
            .update(id, { 'is_active': mode })
            .then((response) => {
              this.$message({
                type: 'success',
                message: 'School Year info has been updated successfully',
                duration: 5 * 1000,
              });
              this.getList();
              this.submitted = false;
            })
            .catch((error) => {
              console.log(error);
            })
            .finally(() => {
              this.getList();
              this.schoolYearFormVisible = false;
              this.submitted = false;
            });
        })
        .catch(() => {
          this.$message({
            type: 'info',
            message: 'Update canceled',
          });
        });
    },
    handleEdit(id, name) {
      this.formTitle = 'Edit School Year ' + name;
      this.currentSchoolYearEdit = this.list.find(
        (schoolYear) => schoolYear.id === id
      );
      console.log(this.currentSchoolYear);
      this.schoolYearFormVisible = true;

      this.resetForm();
      this.currentSchoolYear = {
        id: this.currentSchoolYearEdit.id,
        name: this.currentSchoolYearEdit.name,
        year: this.currentSchoolYearEdit.year,
        start_month: this.currentSchoolYearEdit.start_month,
        end_month: this.currentSchoolYearEdit.end_month,
        payment_mode_id: this.currentSchoolYearEdit.payment_mode_id,
        status: this.currentSchoolYearEdit.status === '1' ? 'Active' : 'Inactive',
        fees: [],
      };
      this.currentSchoolYearEdit.school_year_config.forEach(this.mapDeptFee);
    },
    resetForm() {
      this.currentSchoolYear = {
        id: '',
        name: '',
        year: '',
        start_month: '',
        end_month: '',
        status: '',
        fees: [],
      };
      this.submitted = false;
    },
    getStatus(status){
      return status === '1' ? 'ACTIVE' : 'INACTIVE';
    },
  },
};
</script>

