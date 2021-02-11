<template>
  <div class="createPost-container">
    <el-form ref="postForm" :model="enrollment" class="form-container">
      <sticky :class-name="'sub-navbar active'">
        <el-button
          v-loading="loading"
          style="margin-left: 10px;"
          type="success"
          @click="addStudentPayment"
        >
          Add Payment
        </el-button>
        <el-button v-loading="loading" type="warning" @click="alert()">
          Print Student Account Statement
        </el-button>
      </sticky>

      <div class="createPost-main-container">
        <el-row>
          <el-col :span="24">
            <el-form-item style="margin-bottom: 40px;" prop="title">
              <MDinput :value="enrollment.student.first_name + ' ' +enrollment.student.last_name" :maxlength="100" name="name" readonly>
                Student Name
              </MDinput>
            </el-form-item>

            <div class="postInfo-container">
              <el-row>
                <el-col :span="8">
                  <el-form-item label-width="100px" label="Student No:" class="postInfo-container-item">
                    <el-input
                      :value="enrollment.student.student_no"
                      readonly
                    />
                  </el-form-item>
                </el-col>

                <el-col :span="10">
                  <el-form-item
                    label-width="120px"
                    label="School Year:"
                    class="postInfo-container-item"
                  >
                    <el-input
                      :value="enrollment.school_year.name"
                      readonly
                    />
                  </el-form-item>
                </el-col>

                <el-col :span="6">
                  <el-form-item
                    label-width="80px"
                    label="Section:"
                    class="postInfo-container-item"
                  >
                    <el-input
                      :value="'['+enrollment.grade_level.name + '] ' + enrollment.section.name "
                      readonly
                    />
                  </el-form-item>
                </el-col>
              </el-row>
              <el-row>
                <el-col :span="8">
                  <el-form-item label-width="100px" label="Tuition Fee:" class="postInfo-container-item">
                    <el-input
                      :value="formatPrice(enrollment.enrollment_amount)"
                      readonly
                    />
                  </el-form-item>
                </el-col>

                <el-col :span="10">
                  <el-form-item
                    label-width="120px"
                    label="Payment Mode:"
                    class="postInfo-container-item"
                  >
                    <el-input
                      :value="enrollment.payment_mode_type.name +' ('+enrollment.payment_mode_type.payable_in+')'"
                      readonly
                    />
                  </el-form-item>
                </el-col>

                <el-col :span="6">
                  <el-form-item
                    label-width="80px"
                    label="Balance:"
                    class="postInfo-container-item"
                  >
                    <el-input
                      :value="formatPrice(enrollment.balance)"
                      readonly
                    />
                  </el-form-item>
                </el-col>
              </el-row>
            </div>
          </el-col>
        </el-row>

        <el-form-item style="margin-bottom: 40px;" label-width="80px" label="Status:">
          <el-input
            :value="checkStatus(enrollment.balance)"
            readonly
          />
        </el-form-item>

        <el-form-item prop="content" style="margin-bottom: 30px;">
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

            <el-table-column align="center" label="Due Date">
              <template slot-scope="scope">
                <span>{{ scope.row.payment_due }}</span>
              </template>
            </el-table-column>

            <el-table-column align="center" label="Amount Due">
              <template slot-scope="scope">
                <span>{{ scope.row.payment_amount_due }}</span>
              </template>
            </el-table-column>

            <el-table-column align="center" label="Is Penalized">
              <template slot-scope="scope">
                <span>{{ checkPenalty(scope.row) }}</span>
              </template>
            </el-table-column>

            <el-table-column align="center" label="Total Amount Due">
              <template slot-scope="scope">
                <span>{{ computePenalty(scope.row) }}</span>
              </template>
            </el-table-column>

            <el-table-column align="center" label="Status">
              <template slot-scope="scope">
                <span>{{ isPaid(scope.row.status) }}</span>
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
        </el-form-item>
      </div>
    </el-form>
    <el-dialog :title="formTitle" :visible.sync="newPaymentForm">
      <parent-activity />
    </el-dialog>
  </div>
</template>

<script>
// import Tinymce from '@/components/Tinymce';
// import Upload from '@/components/Upload/SingleImage';
import MDinput from '@/components/MDinput';
import Sticky from '@/components/Sticky'; // Sticky header

import Resource from '@/api/resource';
import permission from '@/directive/permission';
import waves from '@/directive/waves';
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination

const studentPaymentResource = new Resource('studentpayment');
// const schoolYearResource = new Resource('schoolYear');
const studentEnrollment = new Resource('enrollment');

const defaultForm = {
  student: {
    first_name: '',
    last_name: '',
  },
  school_year: {
    name: '',
  },
  section: {
    name: '',
  },
  grade_level: {
    name: '',
  },
  payment_mode_type: {
    name: '',
    payable_in: '',
  },
};

export default {
  name: 'NewStudentPayment',
  components: {
    Sticky,
    MDinput,
    Pagination,
  },
  directives: { permission, waves },
  props: {
    isEdit: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      enrollment_id: false,
      enrollment: Object.assign({}, defaultForm),
      list: [],
      listQuery: {
        page: 1,
        limit: 20,
        title: '',
      },
      total: 0,
      loading: true,
      postForm: [],
      newPaymentForm: false,
      formTitle: '',
      total_due: 0,
    };
  },
  created() {
    const id = this.$route.params && this.$route.params.id;
    if (id) {
      this.enrollment_id = id;
      this.getEnrollment(id);
    }
    this.getList();
  },
  methods: {
    async getEnrollment(enrollment_id) {
      this.loading = true;
      const { data } = await studentEnrollment.list({ id: enrollment_id });
      this.enrollment = data[0];
    },
    async getList() {
      const { limit, page } = this.listQuery;
      this.loading = true;
      const { data } = await studentPaymentResource.list(this.listQuery);
      console.log(data);
      this.list = data.data;
      this.list.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.total = data.total;
      this.loading = false;
    },
    formatPrice(value) {
      const val = (value / 1).toFixed(2).replace(',', '.');
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    },
    checkStatus(balance){
      if (balance > 0){
        return 'UNPAID';
      } else {
        return 'PAID';
      }
    },
    checkPenalty(payment){
      // Create date from input value
      var inputDate = new Date(payment.payment_due);

      // Get today's date
      var todaysDate = new Date();

      // call setHours to take the time out of the comparison
      if ((inputDate.setHours(0, 0, 0, 0) < todaysDate.setHours(0, 0, 0, 0)) && (payment.status === 0)) {
        return 'YES';
      } else {
        return 'NO';
      }
    },
    computePenalty(payment){
      var d1 = new Date(payment.payment_due);
      var d2 = new Date();
      var months;
      months = (d2.getFullYear() - d1.getFullYear()) * 12;
      months -= d1.getMonth();
      months += d2.getMonth();
      months <= 0 ? 0 : months;
      if (months > 0 && payment.status === 0) {
        var penalty = payment.payment_amount_due * parseFloat(months * 0.03);
        return this.formatPrice(parseFloat(penalty) + parseFloat(payment.payment_amount_due));
      } else {
        return this.formatPrice(payment.payment_amount_due);
      }
    },
    isPaid(status){
      if (status === 1) {
        return 'PAID';
      } else {
        return 'UNPAID';
      }
    },
    addStudentPayment(){
      this.newPaymentForm = true;
      this.formTitle = 'Add New Student Payment';
    },
  },
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
@import "~@/styles/mixin.scss";
.createPost-container {
  position: relative;
  .createPost-main-container {
    padding: 0 45px 20px 50px;
    .postInfo-container {
      position: relative;
      @include clearfix;
      margin-bottom: 10px;
      .postInfo-container-item {
        float: left;
      }
    }
  }
  .word-counter {
    width: 40px;
    position: absolute;
    right: -10px;
    top: 0px;
  }
}
</style>
<style>
.createPost-container label.el-form-item__label {
  text-align: left;
}
</style>
