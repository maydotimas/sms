<template>
  <el-card>
    <div class="parent-profile">
      <div class="parent-avatar box-center">
        <pan-thumb
          v-if="parent.avatar"
          :image="image"
          :height="'100px'"
          :width="'100px'"
          :hoverable="false"
        />
      </div>
      <div class="box-center">
        <div class="parent-name text-center">
          {{ parent.first_name }} {{ parent.last_name }}
        </div>
      </div>
      <div class="parent-follow">
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
      :params="parent"
      :width="300"
      :height="300"
      url="/parents/upload-avatar"
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

const parentResource = new Resource('parents');

export default {
  components: { PanThumb, ImageCropper },
  props: {
    parent: {
      type: Object,
      default: () => {
        return {
          id: '',
          avatar: '',
        };
      },
    },
    parentId: {
      type: String,
      default: '0',
    },
  },
  data() {
    return {
      imagecropperShow: false,
      imagecropperKey: 0,
      image: '',
    };
  },
  created() {
    this.updateAvatar();
  },
  methods: {
    cropSuccess(resData) {
      this.imagecropperShow = false;
      this.imagecropperKey = this.imagecropperKey + 1;
      this.image = resData.avatar;
    },
    close() {
      this.imagecropperShow = false;
    },
    async updateAvatar() {
      const { data } = await parentResource.get(this.parentId);
      this.image = data.avatar;
    },
  },
};
</script>

<style lang="scss" scoped>
.parent-profile {
  .parent-name {
    font-weight: bold;
  }
  .box-center {
    padding-top: 10px;
  }
  .parent-role {
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
  .parent-follow {
    padding-top: 20px;
  }
}
</style>
