<template>
  <el-card>
    <div class="student-profile">
      <div class="student-avatar box-center">
        <pan-thumb :image="student.avatar" :height="'100px'" :width="'100px'" :hoverable="false" />
      </div>
      <div class="box-center">
        <div class="student-name text-center">{{ student.first_name }} {{ student.last_name }}</div>
        <div class="student-role text-center text-muted">{{ getRole() }}</div>
      </div>
      <div class="student-follow">
        <el-button type="primary" style="width: 100%;">Upload Photo</el-button>
      </div>
    </div>
  </el-card>
</template>

<script>
import PanThumb from '@/components/PanThumb';

export default {
  components: { PanThumb },
  props: {
    student: {
      type: Object,
      default: () => {
        return {
          name: '',
          email: '',
          avatar: '',
          roles: [],
        };
      },
    },
  },
  data() {
    return {
      social: [
        {
          name: 'Followers',
          count: 1235,
        },
        {
          name: 'Following',
          count: 23512,
        },
        {
          name: 'Friends',
          count: 7242,
        },
      ],
    };
  },
  methods: {
    getRole() {
      const roles = this.student.roles.map((value) =>
        this.$options.filters.uppercaseFirst(value)
      );
      return roles.join(' | ');
    },
  },
};
</script>

<style lang="scss" scoped>
.student-profile {
  .student-name {
    font-weight: bold;
  }
  .box-center {
    padding-top: 10px;
  }
  .student-role {
    padding-top: 10px;
    font-weight: 400;
    font-size: 14px;
  }
  .box-social {
    padding-top: 30px;
    .el-table {
      border-top: 1px solid #dfe6ec;
    }
  }
  .student-follow {
    padding-top: 20px;
  }
}
</style>
