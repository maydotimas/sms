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

      <el-table-column align="center" label="SubFee">
        <template slot-scope="scope">
          <span>{{ scope.row.fee.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Name" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Description">
        <template slot-scope="scope">
          <span>{{ scope.row.description }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Amount">
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
          :model="currentSubFee"
          label-position="left"
          label-width="150px"
          style="max-width: 500px"
        >
          <el-form-item label="Name" prop="name">
            <el-input v-model="currentSubFee.name" />
          </el-form-item>
          <el-form-item label="Description" prop="description">
            <el-input v-model="currentSubFee.description" />
          </el-form-item>
          <el-form-item label="Fees">
            <el-col :span="11">
              <el-button type="success">Add Fee</el-button>
            </el-col>
          </el-form-item>
        </el-form>
        <el-table
          v-loading="listLoading"
          :data="listFee"
          border
          fit
          highlight-current-row
          style="width: 100%"
        >
          <el-table-column width="120px" align="center" label="Name">
            <template slot-scope="scope">
              <span>{{ scope.row.author }}</span>
            </template>
          </el-table-column>

          <el-table-column min-width="300px" label="Amount">
            <template slot-scope="{row}">
              <template v-if="row.edit">
                <el-input v-model="row.title" class="edit-input" size="small" />
                <el-button
                  class="cancel-btn"
                  size="small"
                  icon="el-icon-refresh"
                  type="warning"
                  @click="cancelEdit(row)"
                >cancel</el-button>
              </template>
              <span v-else>{{ row.title }}</span>
            </template>
          </el-table-column>

          <el-table-column align="center" label="Actions" width="120">
            <template slot-scope="{row}">
              <el-button
                v-if="row.edit"
                type="success"
                size="small"
                icon="el-icon-circle-check-outline"
                @click="confirmEdit(row)"
              >Ok</el-button>
              <el-button
                v-else
                type="primary"
                size="small"
                icon="el-icon-edit"
                @click="row.edit=!row.edit"
              >Edit</el-button>
            </template>
          </el-table-column>
        </el-table>
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
import { fetchList } from '@/api/article';

const subFeeResource = new Resource('subFees');
const feeResource = new Resource('fees');

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
      currentSubFee: {},
      submitted: false,
      formTitle: '',
      listFee: [],
      listLoading: false,
    };
  },
  created() {
    this.getList();
    this.getListFee();
  },
  methods: {
    async getList() {
      this.loading = true;
      const { data } = await subFeeResource.list(this.listQuery);
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
      if (this.currentSubFee.id !== undefined) {
        feeResource
          .update(this.currentSubFee.id, this.currentSubFee)
          .then(response => {
            this.$message({
              type: 'success',
              message: 'Fee info has been updated successfully',
              duration: 5 * 1000,
            });
            this.getList();
            this.submitted = false;
          })
          .catch(error => {
            console.log(error);
          })
          .finally(() => {
            this.feeFormVisible = false;
            this.submitted = false;
          });
      } else {
        feeResource
          .store(this.currentSubFee)
          .then(response => {
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
          .catch(error => {
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
          feeResource.destroy(id).then(response => {
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
      this.currentSubFee = this.list.find(fee => fee.id === id);
      this.feeFormVisible = true;
    },
    resetForm() {
      this.currentSubFee = {
        name: '',
        description: '',
      };
    },
    async getListFee() {
      this.listLoading = true;
      const { data } = await fetchList({});
      const items = data.items;
      this.listFee = items.map(v => {
        this.$set(v, 'edit', false); // https://vuejs.org/v2/guide/reactivity.html
        v.originalTitle = v.title; //  will be used when user click the cancel botton
        return v;
      });
      this.listLoading = false;
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
  },
};
</script>

