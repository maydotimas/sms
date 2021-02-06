<template>
  <el-card>
    <el-tabs v-model="activeActivity" @tab-click="handleClick">
      <el-tab-pane label="Parent Information" name="first">
        <div>
          <el-form
            ref="form"
            :rules="rules"
            :model="parent"
            label-width="120px"
          >
            <el-form-item label="Last Name" prop="last_name">
              <el-input
                v-model="parent.last_name"
                aria-placeholder="Last Name"
              />
            </el-form-item>
            <el-form-item label="First Name" prop="first_name">
              <el-input
                v-model="parent.first_name"
                aria-placeholder="First Name"
              />
            </el-form-item>
            <el-form-item label="Middle Name">
              <el-input
                v-model="parent.middle_name"
                aria-placeholder="Middle Name"
              />
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
            <el-form-item label="Relationship" prop="type">
              <el-select
                v-model="parent.type"
                placeholder="Select Relationship to Student"
              >
                <el-option label="Father" value="Father" />
                <el-option label="Mother" value="Mother" />
                <el-option label="Guardian" value="Guardian" />
              </el-select>
            </el-form-item>
            <el-form-item label="Education" prop="education">
              <el-select
                v-model="parent.education"
                placeholder="Educational Attainment"
              >
                <el-option label="N/A" value />
                <el-option label="Vocational" value="Vocational" />
                <el-option
                  label="High School Graduate"
                  value="High School Graduate"
                />
                <el-option
                  label="College Undergrad"
                  value="College Undergrad"
                />
                <el-option label="College Graduate" value="College Graduate" />
                <el-option label="Post Graduate" value="Post Graduate" />
              </el-select>
            </el-form-item>
            <el-form-item label="Email Address" prop="email">
              <el-input
                v-model="parent.email"
                type="email"
                aria-placeholder="E-Mail Address"
              />
            </el-form-item>
            <el-form-item label="Mobile Number" prop="mobile">
              <el-input
                v-model="parent.mobile"
                aria-placeholder="Mobile Number"
              />
            </el-form-item>
            <el-form-item label="Occupation" prop="occupation">
              <el-input
                v-model="parent.occupation"
                aria-placeholder="Father's Occupation"
              />
            </el-form-item>
            <el-form-item label="Office Address" prop="office_address">
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
          id: '',
          first_name: '',
          middle_name: '',
          last_name: '',
          suffix: '',
          occupation: '',
          office_address: '',
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
      rules: {
        last_name: [
          {
            required: true,
            message: 'Please input Last Name',
            trigger: 'blur',
          },
          {
            min: 3,
            max: 40,
            message: 'Length should be 3 to 5',
            trigger: 'blur',
          },
        ],
        first_name: [
          {
            required: true,
            message: 'Please input First Name',
            trigger: 'blur',
          },
          {
            min: 3,
            max: 40,
            message: 'Length should be 3 to 5',
            trigger: 'blur',
          },
        ],
        relationship: [
          {
            required: true,
            message: 'Please input Parent/Guardian Relationship to Student',
            trigger: 'blur',
          },
        ],
        type: [
          {
            required: true,
            message: 'Please input Education',
            trigger: 'blur',
          },
        ],
      },
    };
  },
  methods: {
    handleClick(tab, event) {
      console.log('Switching tab ');
    },
    onSubmit() {
      this.$refs['form'].validate((valid) => {
        if (valid) {
          this.updating = true;
          if (this.parent.id !== undefined && this.parent.id !== '') {
            parentResource
              .update(this.parent.id, this.parent)
              .then((response) => {
                this.$message({
                  type: 'success',
                  message: 'Parent info has been updated successfully',
                  duration: 5 * 1000,
                });
                this.submitted = false;
              })
              .catch((error) => {
                console.log(error);
              })
              .finally(() => {
                this.updating = false;
              });
          } else {
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
                // this.$router.push({ name: 'ParentList' });
              })
              .catch((error) => {
                console.log(error);
              });
          }
        } else {
          console.log('error submit!!');
          return false;
        }
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
