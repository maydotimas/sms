<template>
  <div class="app-container">
    <el-row>
      <el-card class="box-card">
        <div slot="header" class="clearfix">
          <span>Manage Fees for {{ feeTitle }}</span>
        </div>
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
            v-permission="['manage fee']"
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

          <el-table-column align="center" label="Fee Name" width="200">
            <template slot-scope="scope">
              <span>{{ scope.row.name }}</span>
            </template>
          </el-table-column>

          <el-table-column align="center" label="Description">
            <template slot-scope="scope">
              <span>{{ scope.row.description }}</span>
            </template>
          </el-table-column>

          <el-table-column align="center" label="Type">
            <template slot-scope="scope">
              <span>{{ scope.row.type.toUpperCase() }}</span>
            </template>
          </el-table-column>

          <el-table-column align="center" label="Amount">
            <template slot-scope="scope">
              <span v-if="scope.row.type==='REGULAR'">{{ (parseInt(scope.row.tuition) + parseInt(scope.row.misc)) }}</span>
              <span v-if="scope.row.type!=='REGULAR'">{{ scope.row.discount + '%' }}</span>
            </template>
          </el-table-column>

          <el-table-column v-permission="['manage fee']" align="center" label="Actions" width="350">
            <template slot-scope="scope">
              <el-button
                v-permission="['manage fee']"
                type="primary"
                size="small"
                icon="el-icon-edit"
                @click="handleEdit(scope.row.id, scope.row.name)"
              >Edit</el-button>
              <el-button
                v-permission="['manage fee']"
                type="danger"
                size="small"
                icon="el-icon-delete"
                @click="handleDelete(scope.row.id, scope.row.name);"
              >Delete</el-button>
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
      </el-card>
    </el-row>

    <el-dialog v-permission="['manage fee']" :title="formTitle" :visible.sync="feeFormVisible">
      <div class="form-container">
        <el-form
          ref="feeForm"
          :model="currentSubFee"
          label-position="left"
          label-width="150px"
          style="max-width: 500px"
        >
          <el-form-item label="Type" prop="type">
            <el-select
              v-if="isDiscount()"
              v-model="currentSubFee.type"
              class="filter-item"
              placeholder="Please select type"
            >
              <el-option
                v-for="item in feeType"
                :key="item"
                :label="item | uppercaseFirst"
                :value="item"
              />
            </el-select>
            <el-input v-if="isRegular()" v-model="currentSubFee.type" :readonly="true" />
          </el-form-item>

          <el-form-item label="Name" prop="name">
            <el-input v-model="currentSubFee.name" />
          </el-form-item>

          <el-form-item label="Description" prop="description">
            <el-input v-model="currentSubFee.description" />
          </el-form-item>

          <!-- Regular -->
          <el-form-item v-if="isRegular()" label="Tuition" prop="tuition">
            <el-input v-model="currentSubFee.tuition" />
          </el-form-item>

          <el-form-item v-if="isRegular()" label="Miscellaneous" prop="misc">
            <el-input v-model="currentSubFee.misc" />
          </el-form-item>

          <!-- Discount -->

          <el-form-item v-if="isDiscount()" label="Discount (%)" prop="discount">
            <el-input
              v-model="currentSubFee.discount"
              type="number"
              value="10"
              min="1"
              max="100"
              @change="computeDiscount"
              @keyup="computeDiscount"
            />
          </el-form-item>

          <el-form-item v-if="isDiscount()" label="Regular Tuition" prop="regular_tuition">
            <el-input v-model="fee.tuition" :readonly="true" />
          </el-form-item>

          <el-form-item v-if="isDiscount()" label="Discounted Tuition" prop="discounted_tuition">
            <el-input v-model="discounted_tuition" :readonly="true" />
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="feeFormVisible = false">Cancel</el-button>
          <el-button :disabled="submitted" type="primary" @click="handleSubmit">Confirm</el-button>
        </div>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import Resource from '@/api/resource';
import permission from '@/directive/permission';
import waves from '@/directive/waves';
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination

const subFeeResource = new Resource('subFees');
export default {
  name: 'SubFeeList',
  components: { Pagination },
  directives: { permission, waves },
  props: {
    id: {
      type: [String],
      default: function() {
        return {};
      },
    },
  },
  data() {
    return {
      form: [],
      list: [],
      listQuery: {
        fee_id: this.id,
        page: 1,
        limit: 20,
        title: '',
      },
      total: 0,
      loading: true,
      feeFormVisible: false,
      feeType: ['REGULAR', 'SIBLING', 'SCHOLAR', 'DISCOUNT'],
      currentSubFee: {},
      submitted: false,
      formTitle: '',
      feeTitle: '',
      listFee: [],
      listLoading: false,
      hasRegular: false,
      fee: [],
      discounted_tuition: 0,
      mode: 'create',
    };
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      this.loading = true;
      const { data } = await subFeeResource.list(this.listQuery);
      this.fee = data.data[0];
      this.feeTitle = this.fee.name;
      this.list = data.data;
      this.total = data.total;
      this.loading = false;
    },
    handleCreate() {
      this.feeFormVisible = true;
      this.formTitle = 'Create New Fee';
      this.feeType = ['SIBLING', 'SCHOLAR', 'DISCOUNT'];
      this.resetForm();
    },
    handleSubmit() {
      this.submitted = true;
      if (this.currentSubFee.id !== undefined) {
        subFeeResource
          .update(this.currentSubFee.id, this.currentSubFee)
          .then((response) => {
            this.$message({
              type: 'success',
              message: 'Fee info has been updated successfully',
              duration: 5 * 1000,
            });
            this.getList();
            this.resetForm();
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
        subFeeResource
          .store(this.currentSubFee)
          .then((response) => {
            this.$message({
              message:
                'New Fee ' +
                this.currentSubFee.name +
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
            this.submitted = false;
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
          subFeeResource.destroy(id).then((response) => {
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
      this.formTitle = 'Edit Fee ' + name;
      this.currentSubFee = this.list.find((fee) => fee.id === id);
      this.feeFormVisible = true;
      this.feeType = ['REGULAR', 'SIBLING', 'SCHOLAR', 'DISCOUNT'];
      this.computeDiscount();
    },
    resetForm() {
      this.currentSubFee = {
        name: '',
        description: '',
        type: '',
        discount: '',
      };
    },
    cancelEdit(row) {
      row.title = row.originalTitle;
      row.edit = false;
      this.$message({
        message: 'The title has been restored to the original value',
        type: 'warning',
      });
    },
    confirmEdit(row) {
      row.edit = false;
      row.originalTitle = row.title;
      this.$message({
        message: 'The title has been edited',
        type: 'success',
      });
    },
    isRegular() {
      return this.currentSubFee.type === 'REGULAR';
    },
    isDiscount() {
      return this.currentSubFee.type !== 'REGULAR';
    },
    computeDiscount() {
      this.discounted_tuition =
        this.fee.tuition * (this.currentSubFee.discount / 100);
    },
  },
};
</script>

