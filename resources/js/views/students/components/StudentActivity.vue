<template>
  <el-card>
    <el-tabs v-model="activeActivity" @tab-click="handleClick">
      <el-tab-pane label="Personal Information" name="first">
        <div>
          <el-form ref="form" :model="student" label-width="120px">
            <el-form-item label="LRN">
              <el-input v-model="student.lrn" aria-placeholder="LRN (Learners Reference Number)" />
            </el-form-item>
            <el-form-item label="Last Name">
              <el-input v-model="student.last_name" aria-placeholder="Last Name" />
            </el-form-item>
            <el-form-item label="First Name">
              <el-input v-model="student.first_name" aria-placeholder="First Name" />
            </el-form-item>
            <el-form-item label="Middle Name">
              <el-input v-model="student.middle_name" aria-placeholder="Middle Name" />
            </el-form-item>
            <el-form-item label="Suffix">
              <el-select v-model="student.suffix" placeholder="Suffix">
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
            <el-form-item label="Nick Name">
              <el-input v-model="student.nickname" aria-placeholder="Nickname" />
            </el-form-item>
            <el-form-item label="Gender">
              <el-select v-model="student.region" placeholder="Select Gender">
                <el-option label="Male" value="Male" />
                <el-option label="Female" value="Female" />
              </el-select>
            </el-form-item>
            <el-form-item label="Birthdate">
              <el-date-picker
                v-model="student.birthdate"
                type="date"
                placeholder="Select Birtdate"
                style="width: 100%;"
              />
            </el-form-item>
            <el-form-item label="Handedness">
              <el-select v-model="student.handedness" placeholder="Select Handedness">
                <el-option label="Left" value="Left" />
                <el-option label="Right" value="Right" />
                <el-option label="Ambidextrous" value="Ambidextrous" />
              </el-select>
            </el-form-item>
            <el-form-item label="Religion">
              <el-select
                v-model="student.religion"
                auto-complete="true"
                placeholder="Select Religion"
              >
                <el-option label="Ang Dating Daan" value="Ang Dating Daan" />
                <el-option label="Born Again" value="Born Again" />
                <el-option label="Catholic" value="Catholic" />
                <el-option label="Hindu" value="Hindu" />
                <el-option label="Iglesia ni Cristo" value="Iglesia ni Cristo" />
                <el-option label="Islam" value="Islam" />
                <el-option label="Jewish" value="Jewish" />
                <el-option label="Jehovah's Witness" value="Jehovah's Witness" />
                <el-option label="Mormon" value="Mormon" />
                <el-option label="Protestant" value="Protestant" />
                <el-option label="Seventh Day Adventist" value="Seventh Day Adventist" />
                <el-option label="Others" value="Others" />
              </el-select>
            </el-form-item>
            <el-form-item>
              <el-button @click="onCancel">Reset</el-button>
              <el-button type="primary" @click="onNext">Next</el-button>
            </el-form-item>
          </el-form>
        </div>
      </el-tab-pane>
      <el-tab-pane label="Contact Information" name="second">
        <div class="student-activity">
          <el-form ref="form" :model="student" label-width="120px">
            <el-form-item label="Email Address">
              <el-input v-model="student.email" type="email" aria-placeholder="E-Mail Address" />
            </el-form-item>
            <el-form-item label="Mobile Number">
              <el-input v-model="student.mobile" aria-placeholder="Mobile Number" />
            </el-form-item>
            <el-form-item label="Street">
              <el-input v-model="student.street" type="textarea" aria-placeholder="Street" />
            </el-form-item>
            <el-form-item label="Province">
              <el-autocomplete
                v-model="student.province"
                class="inline-input"
                :fetch-suggestions="querySearch"
                placeholder="Please Input Province"
                :trigger-on-focus="true"
                @select="handleSelect"
              />
            </el-form-item>
            <el-form-item label="Municipality">
              <el-autocomplete
                v-model="student.town"
                class="inline-input"
                :fetch-suggestions="querySearch"
                placeholder="Please Input Province"
                :trigger-on-focus="true"
                @select="handleSelect"
              />
            </el-form-item>
            <el-form-item label="Baranggay">
              <el-autocomplete
                v-model="student.brgy"
                class="inline-input"
                :fetch-suggestions="querySearch"
                placeholder="Please Input Province"
                :trigger-on-focus="true"
                @select="handleSelect"
              />
            </el-form-item>
            <el-form-item>
              <el-button @click="onPrevious">Previous</el-button>
              <el-button type="primary" @click="onNext">Next</el-button>
            </el-form-item>
          </el-form>
        </div>
      </el-tab-pane>
      <el-tab-pane v-loading="updating" label="Family Information" name="third">
        <div class="student-activity">
          <el-form ref="form" :model="student" label-width="120px">
            <el-form-item label="Father's Name">
              <el-input v-model="student.father_name" aria-placeholder="Father's Name" />
            </el-form-item>
            <el-form-item label="Occupation">
              <el-input v-model="student.father_occupation" aria-placeholder="Father's Occupation" />
            </el-form-item>
            <el-form-item label="Edducational Attainment">
              <el-select v-model="student.father_education" placeholder="Educational Attainment">
                <el-option label="N/A" value />
                <el-option label="Vocational" value="Vocational" />
                <el-option label="High School Graduate" value="High School Graduate" />
                <el-option label="College Undergrad" value="College Undergrad" />
                <el-option label="College Graduate" value="College Graduate" />
                <el-option label="Post Graduate" value="Post Graduate" />
              </el-select>
            </el-form-item>
            <el-form-item label="Address">
              <el-input
                v-model="student.father_office"
                type="textarea"
                aria-placeholder="Office Address"
              />
            </el-form-item>
            <el-form-item label="Email Address">
              <el-input
                v-model="student.father_email"
                type="email"
                aria-placeholder="E-Mail Address"
              />
            </el-form-item>
            <el-form-item label="Mobile Number">
              <el-input v-model="student.father_mobile" aria-placeholder="Mobile Number" />
            </el-form-item>
            <el-form-item>
              <el-button @click="onCancel">Reset</el-button>
              <el-button type="primary" @click="onNext">Next</el-button>
            </el-form-item>
          </el-form>
        </div>
      </el-tab-pane>
    </el-tabs>
  </el-card>
</template>

<script>
import Resource from '@/api/resource';
const userResource = new Resource('users');

export default {
  props: {
    student: {
      type: Object,
      default: () => {
        return {
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
          avatar: '',
          roles: [],
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
    onNext() {
      // validate fields
      // transfer tab
      if (this.activeActivity === 'first') {
        this.activeActivity = 'second';
      }
      if (this.activeActivity === 'second') {
        this.activeActivity = 'third';
      }
    },
    onPrevious() {
      // validate fields
      // transfer tab
      if (this.activeActivity === 'second') {
        this.activeActivity = 'first';
      }
      if (this.activeActivity === 'third') {
        this.activeActivity = 'second';
      }
    },
    onSubmit() {
      this.updating = true;
      userResource
        .update(this.student.id, this.student)
        .then((response) => {
          this.updating = false;
          this.$message({
            message: 'User information has been updated successfully',
            type: 'success',
            duration: 5 * 1000,
          });
        })
        .catch((error) => {
          console.log(error);
          this.updating = false;
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
.student-activity {
  .student-block {
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
    .student-images {
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
