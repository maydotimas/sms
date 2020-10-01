<template>
  <div class="app-container">
    <el-form :model="student">
      <el-row :gutter="20">
        <el-col :span="18">
          <student-activity @save-student="savestudentdetails" />
        </el-col>
        <el-col :span="6">
          <student-card :student="student" />
        </el-col>
      </el-row>
    </el-form>
  </div>
</template>

<script>
import Resource from '@/api/resource';
import StudentCard from './components/StudentCard';
import StudentActivity from './components/StudentActivity';

const studentResource = new Resource('students');
export default {
  name: 'NewStudent',
  components: { StudentCard, StudentActivity },
  data() {
    return {
      student: {
        type: 1,
        lrn: '',
        student_no: '',
        first_name: '',
        middle_name: '',
        last_name: '',
        suffix: '',
        nickname: '',
        handedness: '',
        religion: '',
        street: '',
        brgy: '',
        town: '',
        province: '',
        mobile: '',
        email: '',
        father: '',
        mother: '',
        guardian: '',
        emergency_contact: '',
        avatar: '',
        roles: [],
      },
    };
  },
  methods: {
    async getUser(id) {
      const { data } = await studentResource.get(id);
      this.student = data;
    },
    savestudentdetails(data) {
      // alert('emitted' + data);
    },
  },
};
</script>
