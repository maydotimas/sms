<template>
  <div class="app-container">
    <el-form :model="parent">
      <el-row :gutter="20">
        <parent-activity />
      </el-row>
    </el-form>
  </div>
</template>

<script>
import Resource from '@/api/resource';
import ParentActivity from './components/ParentActivity';

const studentResource = new Resource('students');
export default {
  name: 'NewParent',
  components: { ParentActivity },
  data() {
    return {
      parent: {
        first_name: '',
        middle_name: '',
        last_name: '',
        suffix: '',
        occupation: '',
        street: '',
        brgy: '',
        town: '',
        province: '',
        mobile: '',
        email: '',
      },
    };
  },
  methods: {
    async getUser(id) {
      const { data } = await studentResource.get(id);
      this.student = data;
    },
  },
};
</script>
