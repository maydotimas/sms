<template>
  <div class="app-container">
    <el-row>
      <el-card class="box-card">
        <div slot="header" class="clearfix">
          <span>Manage Payment Mode Types for {{ paymentModeTypeTitle }}</span>
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
            v-permission="['manage paymentmodetype']"
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

          <el-table-column align="center" label="Percentage">
            <template slot-scope="scope">
              <span>{{ scope.row.percentage.toUpperCase() }}</span>
            </template>
          </el-table-column>

          <el-table-column align="center" label="Payable in">
            <template slot-scope="scope">
              <span>{{ scope.row.payable_in.toUpperCase() }}</span>
            </template>
          </el-table-column>

          <el-table-column v-permission="['manage paymentmodetype']" align="center" label="Actions" width="350">
            <template slot-scope="scope">
              <el-button
                v-permission="['manage paymentmodetype']"
                type="primary"
                size="small"
                icon="el-icon-edit"
                @click="handleEdit(scope.row.id, scope.row.name)"
              >Edit</el-button>
              <el-button
                v-permission="['manage paymentmodetype']"
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

    <el-dialog
      v-permission="['manage paymentmodetype']"
      :title="formTitle"
      :visible.sync="paymentModeTypeFormVisible"
    >
      <div class="form-container">
        <el-form
          ref="feeForm"
          :model="currentPaymentModeType"
          label-position="left"
          label-width="150px"
          style="max-width: 500px"
        >
          <el-form-item label="Name" prop="name">
            <el-input v-model="currentPaymentModeType.name" />
          </el-form-item>

          <el-form-item label="Description" prop="description">
            <el-input v-model="currentPaymentModeType.description" />
          </el-form-item>

          <el-form-item label="Percentage" prop="percentage">
            <el-input v-model="currentPaymentModeType.percentage" type="number" min="1" max="10" />
          </el-form-item>

          <el-form-item label="Payable in" prop="payable_in">
            <el-input v-model="currentPaymentModeType.payable_in" type="number" min="1" max="10" />
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="paymentModeTypeFormVisible = false">Cancel</el-button>
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

const paymentModeTypeResource = new Resource('payment_mode_types');
const paymentModeResource = new Resource('payment_modes');

export default {
  name: 'ManagePaymentModes',
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
        id: this.id,
        payment_mode_id: this.id,
        page: 1,
        limit: 20,
        title: '',
      },
      total: 0,
      loading: true,
      paymentModeTypeFormVisible: false,
      currentPaymentModeType: {
        payment_mode_id: this.id,
      },
      submitted: false,
      formTitle: '',
      paymentModeTypeTitle: '',
      listLoading: false,
      paymentmode: [],
      mode: 'create',
    };
  },
  created() {
    this.getList();
    this.getPageDetail();
  },
  methods: {
    async getList() {
      this.loading = true;
      const { data } = await paymentModeTypeResource.list(this.listQuery);
      this.list = data.data;
      this.total = data.total;
      this.loading = false;
    },
    async getPageDetail() {
      this.loading = true;
      const { data } = await paymentModeResource.list(this.listQuery);
      this.paymentmode = data.data[0];
      console.log(this.paymentmode);
      alert();
      this.paymentModeTypeTitle = this.paymentmode.name;
      this.loading = false;
    },
    handleCreate() {
      this.paymentModeTypeFormVisible = true;
      this.formTitle = 'Create New Payment Mode Type';
      this.resetForm();
    },
    handleSubmit() {
      this.submitted = true;
      if (this.currentPaymentModeType.id !== undefined) {
        paymentModeTypeResource
          .update(this.currentPaymentModeType.id, this.currentPaymentModeType)
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
            this.paymentModeTypeFormVisible = false;
            this.submitted = false;
          });
      } else {
        this.currentPaymentModeType.payment_mode_id = this.id;
        console.log(this.currentPaymentModeType);
        paymentModeTypeResource
          .store(this.currentPaymentModeType)
          .then((response) => {
            this.$message({
              message:
                'New Fee ' +
                this.currentPaymentModeType.name +
                ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.resetForm();
            this.paymentModeTypeFormVisible = false;
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
        'This will permanently delete paymentmode ' + name + '. Continue?',
        'Warning',
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
        }
      )
        .then(() => {
          paymentModeTypeResource.destroy(id).then((response) => {
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
      this.currentPaymentModeType = this.list.find((paymentmode) => paymentmode.id === id);
      this.paymentModeTypeFormVisible = true;
      this.computeDiscount();
    },
    resetForm() {
      this.currentPaymentModeType = {
        payment_mode_id: '',
        name: '',
        description: '',
        percentage: '',
        payable_in: '',
      };
    },
  },
};
</script>

