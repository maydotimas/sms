<template>
  <el-card>
    <div class="student-profile">
      <div class="student-avatar box-center">
        <pan-thumb
          :image="student.avatar"
          :height="'100px'"
          :width="'100px'"
          :hoverable="false"
        />
      </div>
      <div class="box-center">
        <div class="student-name text-center">
          {{ student.first_name }} {{ student.last_name }}
        </div>
      </div>
      <div class="student-follow">
        <el-button
          type="primary"
          style="width: 100%"
          @click="imagecropperShow = true"
        >
          Upload Photo
        </el-button>
      </div>
    </div>
    <image-cropper
      v-show="imagecropperShow"
      :key="imagecropperKey"
      field="img"
      :params="student"
      :width="300"
      :height="300"
      url="/students/upload-avatar"
      lang-type="en"
      @close="close"
      @crop-upload-success="cropSuccess"
    />
  </el-card>
</template>

<script>
import PanThumb from '@/components/PanThumb';
import ImageCropper from '@/components/ImageCropper';
import Resource from '@/api/resource';

const studentResource = new Resource('students');

export default {
  components: { PanThumb, ImageCropper },
  props: {
    student: {
      type: Object,
      default: () => {
        return {
          id: '',
          avatar: '',
        };
      },
    },
    studentId: {
      type: String,
      default: '0',
    },
  },
  data() {
    return {
      imagecropperShow: false,
      imagecropperKey: 0,
      image: this.student.avatar,
      isSaved: false,
      studentData: [],
    };
  },
  created() {
    this.updateAvatar();
  },
  methods: {
    cropSuccess(resData) {
      this.imagecropperShow = false;
      this.imagecropperKey = this.imagecropperKey + 1;
      this.student.avatar = resData.avatar;
      this.$emit('update-avatar', this.student.avatar);
    },
    close() {
      this.imagecropperShow = false;
    },
    async updateAvatar() {
      if (this.studentId === '0') {
        this.image = 'uploads/default.png';
      } else {
        const { data } = await studentResource.get(this.studentId);
        this.image = data.avatar;
        this.studentData = data.avatar;
        this.$emit('update-avatar', this.image);
      }
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
