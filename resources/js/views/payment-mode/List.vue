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
        v-permission="['manage paymentmode']"
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

      <el-table-column align="center" label="Name" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Code" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.code }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Description">
        <template slot-scope="scope">
          <span>{{ scope.row.description }}</span>
        </template>
      </el-table-column>

      <el-table-column v-permission="['manage paymentmode']" align="center" label="Actions" width="350">
        <template slot-scope="scope">
          <el-button
            v-permission="['manage paymentmode']"
            type="primary"
            size="small"
            icon="el-icon-edit"
            @click="handleEdit(scope.row.id, scope.row.name)"
          >Edit</el-button>
          <router-link :to="'/administrator/payment_mode/edit/'+scope.row.id">
            <el-button type="success" size="small" icon="el-icon-menu">Manage Types</el-button>
          </router-link>
          <el-button
            v-permission="['manage paymentmode']"
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

    <el-dialog v-permission="['manage paymentmode']" :title="formTitle" :visible.sync="paymentModeFormVisible">
      <div class="form-container">
        <el-form
          ref="feeForm"
          :model="currentPaymentMode"
          label-position="left"
          label-width="150px"
          style="max-width: 500px"
        >
          <el-form-item label="Name" prop="name">
            <el-input v-model="currentPaymentMode.name" />
          </el-form-item>
          <el-form-item label="Description" prop="description">
            <el-input v-model="currentPaymentMode.description" />
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="paymentModeFormVisible = false">Cancel</el-button>
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

const paymentModeResource = new Resource('payment_modes');

export default {
  name: 'PaymentModeList',
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
      paymentModeFormVisible: false,
      currentPaymentMode: {},
      submitted: false,
      formTitle: '',
    };
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      this.loading = true;
      const { data } = await paymentModeResource.list(this.listQuery);
      console.log(data);
      this.list = data.data;
      this.total = data.total;
      console.log(this.total);
      this.loading = false;
    },
    handleCreate() {
      this.paymentModeFormVisible = true;
      this.resetForm();
      this.formTitle = 'Create New Payment Mode';
    },
    handleSubmit() {
      this.submitted = true;
      if (this.currentPaymentMode.id !== undefined) {
        paymentModeResource
          .update(this.currentPaymentMode.id, this.currentPaymentMode)
          .then((response) => {
            this.$message({
              type: 'success',
              message: 'Payment Mode info has been updated successfully',
              duration: 5 * 1000,
            });
            this.getList();
            this.submitted = false;
          })
          .catch((error) => {
            console.log(error);
          })
          .finally(() => {
            this.paymentModeFormVisible = false;
            this.submitted = false;
          });
      } else {
        paymentModeResource
          .store(this.currentPaymentMode)
          .then((response) => {
            this.$message({
              message:
                'New Payment Mode ' +
                this.currentPaymentMode.name +
                ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.resetForm();
            this.paymentModeFormVisible = false;
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
        'This will permanently delete payment mode ' + name + '. Continue?',
        'Warning',
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
        }
      )
        .then(() => {
          paymentModeResource.destroy(id).then((response) => {
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
      this.formTitle = 'Edit Payment Mode ' + name;
      this.currentPaymentMode = this.list.find((payment_mode) => payment_mode.id === id);
      this.paymentModeFormVisible = true;
    },

    resetForm() {
      this.currentPaymentMode = {
        name: '',
        description: '',
      };
    },
  },
};
</script>

