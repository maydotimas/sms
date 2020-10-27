<template>
  <div class="app-container">
    <el-form :model="student">
      <el-row :gutter="20">
        <el-col :span="18">
          <student-activity
            :student="student"
            @save-student="savestudentdetails"
          />
        </el-col>
        <el-col :span="6">
          <student-card :student="student" @update-avatar="updateAvatar" />
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
        avatar: 'uploads/default.png',
        roles: [],
      },
    };
  },
  created() {
    const id = this.$route.params && this.$route.params.id;
    if (id) {
      this.student_id = id;
      this.getStudent(id);
    }
  },
  methods: {
    async getStudent(id) {
      const { data } = await studentResource.get(id);
      this.student = data;
      this.student.type = 0;
    },
    savestudentdetails(data) {
      this.student = data;
    },
    updateAvatar(data) {
      this.student.avatar = data;
      alert(this.student.avatar);
    },
  },
};
</script>
