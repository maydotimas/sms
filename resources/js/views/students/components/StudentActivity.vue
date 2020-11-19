<template>
  <el-card>
    <el-tabs v-model="activeActivity" @tab-click="handleClick">
      <el-tab-pane label="Personal Information" name="first">
        <div>
          <el-form
            ref="form1"
            :rules="rule1"
            :model="student"
            label-width="120px"
          >
            <el-form-item label="Student Type">
              <el-radio-group v-model="student.type">
                <el-radio v-if="!reservation" :label="0">Old Student</el-radio>
                <el-radio :label="1">New Student</el-radio>
              </el-radio-group>
            </el-form-item>
            <el-form-item v-if="student.type === 0" label="Student No">
              <el-input
                v-model="student.student_no"
                aria-placeholder="LRN (Learners Reference Number)"
              />
            </el-form-item>
            <el-form-item label="LRN">
              <el-input
                v-model="student.lrn"
                aria-placeholder="LRN (Learners Reference Number)"
              />
            </el-form-item>
            <el-form-item label="Last Name" prop="last_name">
              <el-input
                v-model="student.last_name"
                aria-placeholder="Last Name"
              />
            </el-form-item>
            <el-form-item label="First Name" prop="first_name">
              <el-input
                v-model="student.first_name"
                aria-placeholder="First Name"
              />
            </el-form-item>
            <el-form-item label="Middle Name" prop="middle_name">
              <el-input
                v-model="student.middle_name"
                aria-placeholder="Middle Name"
              />
            </el-form-item>
            <el-form-item label="Suffix" prop="suffix">
              <el-select v-model="student.suffix" placeholder="Suffix">
                <el-option label="N/A" value="" />
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
            <el-form-item label="Nick Name" prop="nick_name">
              <el-input
                v-model="student.nickname"
                aria-placeholder="Nickname"
              />
            </el-form-item>
            <el-form-item label="Gender" prop="gender">
              <el-select v-model="student.gender" placeholder="Select Gender">
                <el-option label="Male" value="Male" />
                <el-option label="Female" value="Female" />
              </el-select>
            </el-form-item>
            <el-form-item label="Birthdate" prop="birthdate">
              <el-date-picker
                v-model="student.birthdate"
                type="date"
                placeholder="Select Birtdate"
                style="width: 100%"
              />
            </el-form-item>
            <el-form-item label="Handedness" prop="handedness">
              <el-select
                v-model="student.handedness"
                placeholder="Select Handedness"
              >
                <el-option label="Left" value="Left" />
                <el-option label="Right" value="Right" />
                <el-option label="Ambidextrous" value="Ambidextrous" />
              </el-select>
            </el-form-item>
            <el-form-item label="Religion" prop="religion">
              <el-select
                v-model="student.religion"
                auto-complete="true"
                placeholder="Select Religion"
              >
                <el-option label="Ang Dating Daan" value="Ang Dating Daan" />
                <el-option label="Born Again" value="Born Again" />
                <el-option label="Catholic" value="Catholic" />
                <el-option label="Hindu" value="Hindu" />
                <el-option
                  label="Iglesia ni Cristo"
                  value="Iglesia ni Cristo"
                />
                <el-option label="Islam" value="Islam" />
                <el-option label="Jewish" value="Jewish" />
                <el-option
                  label="Jehovah's Witness"
                  value="Jehovah's Witness"
                />
                <el-option label="Mormon" value="Mormon" />
                <el-option label="Protestant" value="Protestant" />
                <el-option
                  label="Seventh Day Adventist"
                  value="Seventh Day Adventist"
                />
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
          <el-form
            ref="form2"
            :rules="rule2"
            :model="student"
            label-width="120px"
          >
            <el-form-item label="Email Address" prop="email">
              <el-input
                v-model="student.email"
                type="email"
                aria-placeholder="E-Mail Address"
              />
            </el-form-item>
            <el-form-item label="Mobile Number" prop="mobile">
              <el-input
                v-model="student.mobile"
                aria-placeholder="Mobile Number"
              />
            </el-form-item>
            <el-form-item label="Street" prop="street">
              <el-input
                v-model="student.street"
                type="textarea"
                aria-placeholder="Street"
              />
            </el-form-item>
            <el-form-item label="Province" prop="province">
              <el-autocomplete
                v-model="province"
                class="inline-input"
                :fetch-suggestions="provinceSearch"
                placeholder="Please Input Province"
                :trigger-on-focus="true"
                @select="handleSelectProvince"
              />
            </el-form-item>
            <el-form-item label="Municipality" prop="town">
              <el-autocomplete
                v-model="town"
                class="inline-input"
                :fetch-suggestions="townSearch"
                placeholder="Please Input Municipality"
                :trigger-on-focus="true"
                @select="handleSelectTown"
              />
            </el-form-item>
            <el-form-item label="Barangay" prop="emergency_rule">
              <el-autocomplete
                v-model="barangay"
                class="inline-input"
                :fetch-suggestions="brgySearch"
                placeholder="Please Input Barangay"
                :trigger-on-focus="true"
                @select="handleSelectBrgy"
              />
            </el-form-item>
            <el-form-item label="In Case Of Emergency" prop="emergency_rule">
              <el-autocomplete
                v-model="emergency"
                :fetch-suggestions="parentSearch"
                placeholder="Please Input"
                :trigger-on-focus="true"
                @select="handleSelectEmergency"
              />
            </el-form-item>
            <el-form-item>
              <el-button @click="onPrevious">Previous</el-button>
              <el-button type="primary" @click="onNext">Next</el-button>
            </el-form-item>
          </el-form>
        </div>
      </el-tab-pane>
      <el-tab-pane label="Family Information" name="third">
        <div class="student-activity">
          <el-form ref="form3" :model="student" label-width="120px">
            <el-form-item label="Father">
              <el-autocomplete
                v-model="father"
                :fetch-suggestions="popSearch"
                placeholder="Please Input"
                @select="handleSelectFather"
              />
            </el-form-item>
            <el-form-item label="Mother">
              <el-autocomplete
                v-model="mother"
                :fetch-suggestions="momSearch"
                placeholder="Please Input"
                @select="handleSelectMother"
              />
            </el-form-item>
            <el-form-item label="Guardian">
              <el-autocomplete
                v-model="guardian"
                :fetch-suggestions="guardianSearch"
                placeholder="Please Input"
                @select="handleSelectGuardian"
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
const studentResource = new Resource('students');
// const parentResource = new Resource('parents');
const provinceResource = new Resource('province');
const cityResource = new Resource('city');
const brgyResource = new Resource('barangay');
const parentResource = new Resource('studentparents');

export default {
  props: {
    reservation: {
      type: Boolean,
      default: false,
    },
    student: {
      type: Object,
      default: () => {
        return {
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
        };
      },
    },
  },
  data() {
    /* Custom Rules */
    var checkEmail = (rule, value, callback) => {
      if (!value) {
        return callback(new Error('Please input email'));
      }
      if (
        /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(
          value
        )
      ) {
        return callback();
      } else {
        return callback(new Error('Invalid email format'));
      }
    };
    return {
      /* Query data */
      fatherQuery: {
        page: 1,
        limit: 20,
        title: this.father,
        type: 'father',
      },
      motherQuery: {
        page: 1,
        limit: 20,
        title: this.mother,
        type: 'mother',
      },
      guardianQuery: {
        page: 1,
        limit: 20,
        title: this.guardian,
        type: 'guardian',
      },
      parentQuery: {
        page: 1,
        limit: 20,
        title: this.parent,
        type: 'all',
      },
      provinceQuery: {
        page: 1,
        limit: 20,
        title: '',
      },
      townQuery: {
        page: 1,
        limit: 20,
        title: '',
      },
      brgyQuery: {
        page: 1,
        limit: 20,
        title: '',
      },
      /* Rules */
      rule1: {
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
        gender: [
          {
            required: true,
            message: 'Please input Gender',
            trigger: 'blur',
          },
          {
            required: true,
            message: 'Please input Gender',
            trigger: 'change',
          },
        ],
        birthdate: [
          {
            required: true,
            message: 'Please input birthdate',
            trigger: 'blur',
          },
          {
            required: true,
            message: 'Please input birthdate',
            trigger: 'change',
          },
        ],
        handedness: [
          {
            required: true,
            message: 'Please select handedness',
            trigger: 'blur',
          },
          {
            required: true,
            message: 'Please input handedness',
            trigger: 'change',
          },
        ],
        religion: [
          {
            required: true,
            message: 'Please select religion',
            trigger: 'blur',
          },
          {
            required: true,
            message: 'Please input religion',
            trigger: 'change',
          },
        ],
      },
      rule2: {
        email: [{ required: true, validator: checkEmail, trigger: 'blur' }],
        mobile: [
          {
            required: true,
            message: 'Please input Mobile',
            trigger: 'blur',
          },
          {
            min: 3,
            max: 40,
            message: 'Length should be 3 to 5',
            trigger: 'blur',
          },
        ],
        street: [
          {
            required: true,
            message: 'Please input Street',
            trigger: 'blur',
          },
        ],
        province: [
          {
            required: true,
            message: 'Please input Province',
            trigger: 'blur',
          },
          {
            required: true,
            message: 'Please input Province',
            trigger: 'change',
          },
        ],
        town: [
          {
            required: true,
            message: 'Please select Town',
            trigger: 'blur',
          },
          {
            required: true,
            message: 'Please input Town',
            trigger: 'change',
          },
        ],
        barangay: [
          {
            required: true,
            message: 'Please select Barangay',
            trigger: 'blur',
          },
          {
            required: true,
            message: 'Please input Barangay',
            trigger: 'change',
          },
        ],
      },
      /* Select dropdown values */
      links: [],
      fathers: [],
      mothers: [],
      guardians: [],
      parents: [],
      provinces: [],
      cities: [],
      barangays: [],
      activeActivity: 'first',
      updating: false,
      /* Selected value */
      father: '',
      mother: '',
      guardian: '',
      emergency: '',
      parent: '',
      province: '',
      town: '',
      barangay: '',
      /* Form Validation */
      form1Valid: false,
      form2Valid: false,
      form3Valid: false,
    };
  },
  mounted() {},
  methods: {
    handleClick(tab, event) {
      if (tab.name === 'first') {
        this.activeActivity = 'first';
      } else if (tab.name === 'second') {
        this.activeActivity = 'second';
      } else if (tab.name === 'third') {
        this.activeActivity = 'third';
      } else {
        this.activeActivity = 'fourth';
      }
      console.log('Switching tab ');
    },
    onNext() {
      // validate fields
      // transfer tab
      if (this.activeActivity === 'first') {
        this.$refs['form1'].validate((valid) => {
          if (valid) {
            this.form1Valid = true;
            this.activeActivity = 'second';
          } else {
            this.form1Valid = false;
          }
        });
      } else if (this.activeActivity === 'second') {
        this.$refs['form2'].validate((valid) => {
          if (valid) {
            this.form2Valid = true;
            this.activeActivity = 'third';
          } else {
            this.form2Valid = false;
          }
        });
      } else if (this.activeActivity === 'third') {
        this.$refs['form3'].validate((valid) => {
          if (valid) {
            this.form2Valid = true;
            this.activeActivity = 'fourth';
          } else {
            this.form2Valid = false;
          }
        });
      }
    },
    onPrevious() {
      // validate fields
      // transfer tab
      if (this.activeActivity === 'second') {
        this.activeActivity = 'first';
      } else if (this.activeActivity === 'third') {
        this.activeActivity = 'second';
      }
    },
    onSubmit() {
      this.$refs['form3'].validate((valid) => {
        if (this.form1Valid && this.form2Valid && valid) {
          if (this.student.father === '' && this.student.mother === '') {
            alert('student parent is required');
            return false;
          }
          this.updating = true;
          if (this.student.id !== undefined && this.student.id !== '') {
            studentResource
              .update(this.student.id, this.student)
              .then((response) => {
                this.$message({
                  type: 'success',
                  message: 'Student info has been updated successfully',
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
            console.log(this.student);
            studentResource
              .store(this.student)
              .then((response) => {
                this.$message({
                  message:
                    'New Student ' +
                    this.student.first_name +
                    ' ' +
                    this.student.last_name +
                    ' has been created successfully.',
                  type: 'success',
                  duration: 5 * 1000,
                });
                console.log(response);
                this.updating = false;
                this.$emit('save-student', response.data);
                // this.$router.push({ name: 'ParentList' });
              })
              .catch((error) => {
                console.log(error);
              });
          }
        } else {
          this.activeActivity = 'first';
          return false;
        }
      });
    },
    onCancel() {
      return false;
    },
    async popSearch(queryString, cb) {
      var results = await this.loadFather();
      // call callback function to return suggestions
      cb(results);
    },
    async momSearch(queryString, cb) {
      var results = await this.loadMother();
      // call callback function to return suggestions
      cb(results);
    },
    async guardianSearch(queryString, cb) {
      var results = await this.loadGuardian();
      // call callback function to return suggestions
      cb(results);
    },
    async parentSearch(queryString, cb) {
      var results = await this.loadParents();
      // call callback function to return suggestions
      cb(results);
    },
    async provinceSearch(queryString, cb) {
      var results = await this.loadProvince();
      // call callback function to return suggestions
      cb(results);
    },
    async townSearch(queryString, cb) {
      var links = this.cities;
      var results = queryString
        ? links.filter(this.createFilter(queryString))
        : links;
      // call callback function to return suggestions
      cb(results);
    },
    async brgySearch(queryString, cb) {
      var links = this.barangays;
      var results = queryString
        ? links.filter(this.createFilter(queryString))
        : links;
      // call callback function to return suggestions
      cb(results);
    },

    async loadFather() {
      this.fatherQuery.title = this.father;
      const { data } = await parentResource.ask(this.fatherQuery);
      this.fathers = data.data;
      return data.data;
    },
    async loadMother() {
      this.motherQuery.title = this.mother;
      const { data } = await parentResource.ask(this.motherQuery);
      this.mothers = data.data;
      return data.data;
    },
    async loadGuardian() {
      this.guardianQuery.title = this.guardian;
      const { data } = await parentResource.ask(this.guardianQuery);
      this.guardians = data.data;
      return data.data;
    },
    async loadParents() {
      this.parentQuery.title = this.emergency;
      const { data } = await parentResource.ask(this.parentQuery);
      this.parents = data.data;
      return data.data;
    },
    async loadProvince() {
      if (this.province === '') {
        this.provinceQuery.title = this.student.province;
      } else {
        this.provinceQuery.title = this.province;
      }
      const { data } = await provinceResource.ask(this.provinceQuery);
      this.provinces = data;
      return data.data;
    },
    async loadTown() {
      this.townQuery.title = this.student.province;
      console.log(this.townQuery);
      const { data } = await cityResource.ask(this.townQuery);
      console.log(this.cities);
      this.cities = data;
      return data;
    },
    async loadBrgy() {
      this.brgyQuery.title = this.student.town;
      const { data } = await brgyResource.ask(this.brgyQuery);
      this.barangays = [];
      this.barangays = data;
      return data;
    },
    createFilter(queryString) {
      return (link) => {
        return (
          link.value.toLowerCase().indexOf(queryString.toLowerCase()) === 0
        );
      };
    },
    handleSelectProvince(item) {
      this.student.province = item.link;
      this.loadTown();
    },
    handleSelectTown(item) {
      this.student.town = item.link;
      this.loadBrgy();
    },
    handleSelectBrgy(item) {
      this.student.brgy = item.link;
    },
    handleSelectFather(item) {
      this.student.father = item.link;
    },
    handleSelectMother(item) {
      this.student.mother = item.link;
    },
    handleSelectGuardian(item) {
      this.student.guardian = item.link;
    },
    handleSelectEmergency(item) {
      this.student.emergency_contact = item.link;
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
