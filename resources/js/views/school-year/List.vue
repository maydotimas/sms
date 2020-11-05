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
        @click="getList"
        >{{ $t('table.search') }}</el-button
      >
      <el-button
        v-permission="['manage gradelevel']"
        class="filter-item"
        type="primary"
        icon="el-icon-plus"
        @click="handleCreate"
        >{{ $t('table.add') }}</el-button
      >
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

      <el-table-column align="center" label="Start Month" width="150">
        <template slot-scope="scope">
          <span>{{ scope.row.start_month }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="End Month" width="150">
        <template slot-scope="scope">
          <span>{{ scope.row.end_month }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Status" width="100">
        <template slot-scope="scope">
          <span>{{ scope.row.status == 1 ? 'Active' : 'Inactive' }}</span>
        </template>
      </el-table-column>

      <el-table-column
        v-permission="['manage gradelevel']"
        align="center"
        label="Actions"
        width="200"
      >
        <template slot-scope="scope">
          <el-button
            v-permission="['manage gradelevel']"
            type="primary"
            size="small"
            icon="el-icon-edit"
            @click="handleEdit(scope.row.id, scope.row.name)"
            >Edit</el-button
          >
          <el-button
            v-permission="['manage gradelevel']"
            type="danger"
            size="small"
            icon="el-icon-delete"
            @click="handleDelete(scope.row.id, scope.row.name)"
            >Delete</el-button
          >
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

    <el-dialog
      v-permission="['manage gradelevel']"
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
          <!--  <el-form-item :label="$t('table.department')" prop="department_id">
            <el-select
              v-model="currentSchoolYear.department_id"
              class="filter-item"
              placeholder="Please select department"
            >
              <el-option
                v-for="item in deptList"
                :key="item.id"
                :label="item.name | uppercaseFirst"
                :value="item.id"
              />
            </el-select>
          </el-form-item> -->
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
          <div v-for="item in deptList" :key="item.id">
            <el-form-item :label="item.name" prop="department_id">
              <el-select
                v-model="currentSchoolYear.paymentConfig"
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
          <el-button @click="schoolYearFormVisible = false">Cancel</el-button>
          <el-button :disabled="submitted" type="primary" @click="handleSubmit"
            >Confirm</el-button
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

const schoolYearResource = new Resource('schoolYear');
const feeResource = new Resource('fees');
const departmentResource = new Resource('departments');

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
      loading: true,
      schoolYearFormVisible: false,
      currentSchoolYear: {},
      submitted: false,
      formTitle: '',
    };
  },
  created() {
    this.getList();
    this.getDeptList();
    this.getFeeList();
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
      this.feeList = data.data.data;
      console.log(data.data[0].data)
      this.loading = false;
    },
    handleCreate() {
      this.schoolYearFormVisible = true;
      this.resetForm();
      this.formTitle = 'Create New School Year';
    },
    handleSubmit() {
      this.submitted = true;
      if (this.currentSchoolYear.id !== undefined) {
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
    handleEdit(id, name) {
      this.formTitle = 'Edit School Year ' + name;
      this.currentSchoolYear = this.list.find(
        (schoolYear) => schoolYear.id === id
      );
      console.log(this.currentSchoolYear);
      this.schoolYearFormVisible = true;
    },
    resetForm() {
      this.currentSchoolYear = {
        name: '',
        year: '',
        start_month: '',
        start_end: '',
        status: '',
      };
    },
  },
};
</script>

