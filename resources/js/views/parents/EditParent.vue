<template>
  <div class="app-container">
    <el-form :model="parent">
      <el-row :gutter="20">
        <el-col :span="6">
          <parent-card :propParent="parent" @update-parent="onUpdateParent" />
          <!-- <student-bio  :student="student"/> -->
        </el-col>
        <el-col :span="18">
          <parent-activity :parent="parent" />
        </el-col>
      </el-row>
    </el-form>
  </div>
</template>

<script>
import Resource from '@/api/resource';
import ParentCard from './components/ParentCard';
import ParentActivity from './components/ParentActivity';

const parentResource = new Resource('parents');

export default {
  name: 'EditParent',
  components: { ParentCard, ParentActivity },
  data() {
    return {
      parent: {
        id: '',
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
        avatar: '',
      },
    };
  },
  created() {
    const id = this.$route.params && this.$route.params.id;
    this.getParent(id);
  },
  methods: {
    async getParent(id) {
      const { data } = await parentResource.get(id);
      this.parent = data;
    },
    onUpdateParent(data){
      this.parent = data;
    },
  },
};
</script>
