<template>
  <form @submit.prevent="handleSubmit">
    <label>Email:</label>
    <input
      v-model="email"
      type="email"
      required
    >

    <label>Password:</label>
    <input
      v-model="password"
      type="password"
      required
    >
    <div
      v-if="passwordError"
      class="error"
    >
      {{ passwordError }}
    </div>

    <label>Role:</label>
    <select v-model="role">
      <option value="developer">
        Web Developer
      </option>
      <option value="designer">
        Web Designer
      </option>
    </select>

    <label>Skills:</label>
    <input
      v-model="tempSkill"
      type="text"
      @keyup="addSkill"
    >
    <div
      v-for="skill in skills"
      :key="skill"
      class="pill"
    >
      <span @click="removeSkill(skill)">{{ skill }}</span>
    </div>

    <div class="terms">
      <input
        v-model="terms"
        type="checkbox"
        required
      >
      <label>Accept terms and conditions</label>
    </div>

    <div class="submit">
      <button>Create an Account</button>
    </div>
  </form>
  <p>Email: {{ email }}</p>
  <p>Password: {{ password }}</p>
  <p>Role: {{ role }}</p>
  <p>Terms: {{ terms }}</p>
</template>
<script>
export default {
    data() {
        return {
            email: '',
            password: '',
            role: 'designer',
            terms: false,
            tempSkill: '',
            skills: [],
            passwordError: '',
        }
    },
    methods: {
        addSkill(e) {
            if (e.key === ',' && this.tempSkill) {
                const skillWithoutComma = this.tempSkill.replace(/,/g, '').trim();
                if (skillWithoutComma !== '' && !this.skills.includes(skillWithoutComma)) {
                    this.skills.push(skillWithoutComma);
                }
                this.tempSkill = ''
            }
        },
        removeSkill(skill) {
            this.skills = this.skills.filter((item) => {
                return skill !== item
            })
        },
        handleSubmit() {
            this.passwordError = this.password.length > 5 ? '' : 'Password must be at least 6 chars long'

            if (!this.passwordError) {
                console.log('email', this.email)
                console.log('password', this.password)
                console.log('role', this.role)
                console.log('skills', this.skills)
                console.log('terms accepted', this.terms)
            }
        },
    },
}
</script>
<style>
    .pill {
        display: inline-block;
        margin: 20px 10px 0 0;
        padding: 6px 12px;
        background: rgba(0, 0, 0, 0.3);
        border-radius: 20px;
        font-size: 12px;
        letter-spacing: 1px;
        font-weight: bold;
        color: rgba(255, 255, 255, 0.8);
        cursor: pointer;
    }
    .submit {
        text-align: center;
    }
    .submit>button {
        border-radius: 20px;
        padding: 10px 20px;
        margin-top: 20px;
    }
    .error {
        color: #ff5555;
        margin-top: 10px;
        font-size: 0.8em;
        font-weight: bold;
    }
</style>