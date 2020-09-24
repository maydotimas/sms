<template>
  <el-card>
    <el-tabs v-model="activeActivity" @tab-click="handleClick">
      <el-tab-pane label="Parent Information" name="first">
        <div>
          <el-form ref="form" :model="parent" label-width="120px">
            <el-form-item label="Last Name">
              <el-input v-model="parent.last_name" aria-placeholder="Last Name" />
            </el-form-item>
            <el-form-item label="First Name">
              <el-input v-model="parent.first_name" aria-placeholder="First Name" />
            </el-form-item>
            <el-form-item label="Middle Name">
              <el-input v-model="parent.middle_name" aria-placeholder="Middle Name" />
            </el-form-item>
            <el-form-item label="Suffix">
              <el-select v-model="parent.suffix" placeholder="Suffix">
                <el-option label="N/A" value />
                <el-option label="JR" value="JR" />
                <el-option label="II" value="II" />
                <el-option label="III" value="III" />
                <el-option label="IV" value="IV" />
                <el-option label="V" value="V" />
                <el-option label="VI" value="VI" />
                <el-option label="VII" value="VII" />
                <el-option label="VIII" value="VIII" />
                <el-option label="IX" value="IX" />
                <el-option label="X" value="X" />
              </el-select>
            </el-form-item>
            <el-form-item label="Relationship">
              <el-select v-model="parent.type" placeholder="Select Relationship to Student">
                <el-option label="Father" value="Father" />
                <el-option label="Mother" value="Mother" />
                <el-option label="Guardian" value="Guardian" />
              </el-select>
            </el-form-item>
            <el-form-item label="Education">
              <el-select v-model="parent.education" placeholder="Educational Attainment">
                <el-option label="N/A" value />
                <el-option label="Vocational" value="Vocational" />
                <el-option label="High School Graduate" value="High School Graduate" />
                <el-option label="College Undergrad" value="College Undergrad" />
                <el-option label="College Graduate" value="College Graduate" />
                <el-option label="Post Graduate" value="Post Graduate" />
              </el-select>
            </el-form-item>
            <el-form-item label="Email Address">
              <el-input v-model="parent.email" type="email" aria-placeholder="E-Mail Address" />
            </el-form-item>
            <el-form-item label="Mobile Number">
              <el-input v-model="parent.mobile" aria-placeholder="Mobile Number" />
            </el-form-item>
            <el-form-item label="Occupation">
              <el-input v-model="parent.occupation" aria-placeholder="Father's Occupation" />
            </el-form-item>
            <el-form-item label="Office Address">
              <el-input
                v-model="parent.office_address"
                type="textarea"
                aria-placeholder="Office Address"
              />
            </el-form-item>
            <el-form-item>
              <el-button @click="onCancel">Reset</el-button>
              <el-button type="primary" @click="onSubmit">Submit</el-button>
            </el-form-item>
          </el-form>
        </div>
      </el-tab-pane>
    </el-tabs>
  </el-card>
</template>

<script>
import Resource from '@/api/resource';
const parentResource = new Resource('parents');

export default {
  props: {
    parent: {
      type: Object,
      default: () => {
        return {
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
        };
      },
    },
  },
  data() {
    return {
      activeActivity: 'first',
      updating: false,
      links: [],
      provinceArr: [],
    };
  },
  mounted() {
    this.links = this.loadAll();
  },
  methods: {
    handleClick(tab, event) {
      console.log('Switching tab ');
    },
    onSubmit() {
      this.updating = true;
      parentResource
        .store(this.parent)
        .then((response) => {
          this.$message({
            message:
              'New Parent ' +
              this.parent.first_name +
              ' ' +
              this.parent.last_name +
              ' has been created successfully.',
            type: 'success',
            duration: 5 * 1000,
          });
          this.updating = false;
          this.$router.push({ name: 'ParentList' })
        })
        .catch((error) => {
          console.log(error);
        });
    },
    onCancel() {
      return false;
    },
    querySearch(queryString, cb) {
      var links = this.links;
      var results = queryString
        ? links.filter(this.createFilter(queryString))
        : links;
      // call callback function to return suggestions
      cb(results);
    },
    loadAll() {},
    createFilter(queryString) {
      return (link) => {
        return (
          link.value.toLowerCase().indexOf(queryString.toLowerCase()) === 0
        );
      };
    },
    handleSelect(item) {
      console.log(item);
    },
  },
};
</script>

<style lang="scss" scoped>
.parent-activity {
  .parent-block {
    .username,
    .description {
      display: block;
      margin-left: 50px;
      padding: 2px 0;
    }
    img {
      width: 40px;
      height: 40px;
      float: left;
    }
    :after {
      clear: both;
    }
    .img-circle {
      border-radius: 50%;
      border: 2px solid #d2d6de;
      padding: 2px;
    }
    span {
      font-weight: 500;
      font-size: 12px;
    }
  }
  .post {
    font-size: 14px;
    border-bottom: 1px solid #d2d6de;
    margin-bottom: 15px;
    padding-bottom: 15px;
    color: #666;
    .image {
      width: 100%;
    }
    .parent-images {
      padding-top: 20px;
    }
  }
  .list-inline {
    padding-left: 0;
    margin-left: -5px;
    list-style: none;
    li {
      display: inline-block;
      padding-right: 5px;
      padding-left: 5px;
      font-size: 13px;
    }
    .link-black {
      &:hover,
      &:focus {
        color: #999;
      }
    }
  }
  .el-carousel__item h3 {
    color: #475669;
    font-size: 14px;
    opacity: 0.75;
    line-height: 200px;
    margin: 0;
  }

  .el-carousel__item:nth-child(2n) {
    background-color: #99a9bf;
  }

  .el-carousel__item:nth-child(2n + 1) {
    background-color: #d3dce6;
  }
}
</style>
