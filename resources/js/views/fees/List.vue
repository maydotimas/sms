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

      <el-table-column v-permission="['manage fee']" align="center" label="Actions" width="350">
        <template slot-scope="scope">
          <el-button
            v-permission="['manage fee']"
            type="primary"
            size="small"
            icon="el-icon-edit"
            @click="handleEdit(scope.row.id, scope.row.name)"
          >Edit</el-button>
          <router-link :to="'/administrator/fees/edit/'+scope.row.id">
            <el-button type="success" size="small" icon="el-icon-menu">Manage Fees</el-button>
          </router-link>
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

    <el-dialog v-permission="['manage fee']" :title="formTitle" :visible.sync="feeFormVisible">
      <div class="form-container">
        <el-form
          ref="feeForm"
          :model="currentFee"
          label-position="left"
          label-width="150px"
          style="max-width: 500px"
        >
          <el-form-item label="Name" prop="name">
            <el-input v-model="currentFee.name" />
          </el-form-item>
          <el-form-item label="Description" prop="description">
            <el-input v-model="currentFee.description" />
          </el-form-item>
          <el-form-item label="Tuition" prop="tuition">
            <el-input v-model="currentFee.tuition" type="number" />
          </el-form-item>
          <el-form-item label="Miscellaneous" prop="misc">
            <el-input v-model="currentFee.misc" type="number" />
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

const feeResource = new Resource('fees');

export default {
  name: 'FeeList',
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
      currentFee: {},
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
      const { data } = await feeResource.list(this.listQuery);
      console.log(data);
      this.list = data.data;
      this.total = data.total;
      console.log(this.total);
      this.loading = false;
    },
    handleCreate() {
      this.feeFormVisible = true;
      this.resetForm();
      this.formTitle = 'Create New Fee';
    },
    handleSubmit() {
      this.submitted = true;
      if (this.currentFee.id !== undefined) {
        feeResource
          .update(this.currentFee.id, this.currentFee)
          .then((response) => {
            this.$message({
              type: 'success',
              message: 'Fee info has been updated successfully',
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
        feeResource
          .store(this.currentFee)
          .then((response) => {
            this.$message({
              message:
                'New Fee ' +
                this.currentFee.name +
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
          feeResource.destroy(id).then((response) => {
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
      this.currentFee = this.list.find((fee) => fee.id === id);
      this.feeFormVisible = true;
    },

    resetForm() {
      this.currentFee = {
        name: '',
        description: '',
        tuition: '0',
        misc: '0',
      };
    },
  },
};
</script>

