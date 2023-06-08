<template>
    <form>
        <label>Email:</label>
        <input type="email" required v-model="email">

        <label>Password:</label>
        <input type="password" required v-model="password">

        <label>Role:</label>
        <select v-model="role">
            <option value="developer">Web Developer</option>
            <option value="designer">Web Designer</option>
        </select>

        <label>Skills:</label>
        <input type="text" v-model="tempSkill" @keyup="addSkill">
        <div v-for="skill in skills" :key="skill" class="pill">
            <span @click="removeSkill(skill)">{{ skill }}</span>
        </div>

        <div class="terms">
            <input type="checkbox" v-model="terms" required>
            <label>Accept terms and conditions</label>
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
    },
}
</script>
<style>
    form {
        max-width: 420px;
        margin: 30px auto;
        background: darkslategray;
        text-align: left;
        padding: 40px;
        border-radius: 10px;
    }
    label {
        color: #fff;
        display: inline-block;
        margin: 25px 0 15px;
        font-size: 0.6em;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: bold;
    }
    input, select {
        display: block;
        padding: 10px 6px;
        width: 100%;
        box-sizing: border-box;
        border: none;
        border-bottom: 1px solid #ddd;
        background: darkslategray;
        color: #fff;
    }
    input[type="checkbox"] {
        display: inline-block;
        width: 16px;
        margin: 0 10px 0 0;
        position: relative;
        top: 2px;
    }
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
</style>