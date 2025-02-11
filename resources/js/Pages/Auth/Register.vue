<script setup>
import { ref } from "vue";
import { useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    student_id: '',
    grade_level: '',
    section: ''
});

const errors = ref({});
const showPassword = ref(false);
const loading = ref(false);

// Toggle password visibility
const togglePassword = () => {
    showPassword.value = !showPassword.value;
};

// Handle registration submission
const submit = async () => {
    loading.value = true;
    try {
        await form.post(route('register'), {
            onSuccess: () => {
                window.location.href = route('admin.teacher.index');
            },
            onError: (e) => {
                errors.value = e;
            },
            onFinish: () => {
                loading.value = false;
            }
        });
    } catch (error) {
        console.error('Registration error:', error);
        loading.value = false;
    }
};

// Handle Google login
const googleLogin = () => {
    loading.value = true;
    try {
        window.location.href = route('google.login');
    } catch (error) {
        console.error('Google login error:', error);
        loading.value = false;
    }
};
</script>

<template>
    <form @submit.prevent="submit">
        <div class="login">
            <div class="overlap-wrapper">
                <div class="overlap">
                    <div class="main-dashboard">
                        <img class="background" src="Assets/img/background.png" alt="Background" />
                    </div>
                    <div class="rectangle"></div>
                    <div class="bg"></div>

                    <!-- Header -->
                    <h1 class="welcome-students">
                        <span class="text-wrapper">Register </span>
                        <span class="span">Student </span>
                    </h1>

                    <!-- Google Login Button -->
                    <a href="#" @click="googleLogin" class="login-with-google">
                        <div class="group">
                            <img class="search" src="Assets/img/search-1.svg" alt="Search Icon" />
                            <span class="div">Register with Google</span>
                        </div>
                    </a>

                    <!-- OR Separator -->
                    <div class="or">
                        <img class="line" src="Assets/img/line-1.svg" alt="Line" />
                        <img class="img" src="Assets/img/line-2.svg" alt="Line" />
                        <div class="text-wrapper-2">OR</div>
                    </div>

                    <!-- Registration Form -->
                    <div class="form-container">
                        <!-- Name Input -->
                        <div class="form-group">
                            <div class="overlap-group">
                                <img class="vector" src="Assets/img/user.svg" alt="Name Icon" />
                                <label class="text-wrapper-4" for="name">Full Name</label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    class="text-wrapper-5" 
                                    v-model="form.name" 
                                    required
                                />
                                <div v-if="errors.name" class="error-message">{{ errors.name }}</div>
                            </div>
                        </div>

                        <!-- Student ID Input -->
                        <div class="form-group">
                            <div class="overlap-group">
                                <img class="vector" src="Assets/img/id.svg" alt="ID Icon" />
                                <label class="text-wrapper-4" for="student_id">Student ID</label>
                                <input 
                                    type="text" 
                                    id="student_id" 
                                    class="text-wrapper-5" 
                                    v-model="form.student_id" 
                                    required
                                />
                                <div v-if="errors.student_id" class="error-message">{{ errors.student_id }}</div>
                            </div>
                        </div>

                        <!-- Grade Level Input -->
                        <div class="form-group">
                            <div class="overlap-group">
                                <img class="vector" src="Assets/img/grade.svg" alt="Grade Icon" />
                                <label class="text-wrapper-4" for="grade_level">Grade Level</label>
                                <select 
                                    id="grade_level" 
                                    class="text-wrapper-5" 
                                    v-model="form.grade_level" 
                                    required
                                >
                                    <option value="">Select Grade Level</option>
                                    <option value="7">Grade 7</option>
                                    <option value="8">Grade 8</option>
                                    <option value="9">Grade 9</option>
                                    <option value="10">Grade 10</option>
                                    <option value="11">Grade 11</option>
                                    <option value="12">Grade 12</option>
                                </select>
                                <div v-if="errors.grade_level" class="error-message">{{ errors.grade_level }}</div>
                            </div>
                        </div>

                        <!-- Section Input -->
                        <div class="form-group">
                            <div class="overlap-group">
                                <img class="vector" src="Assets/img/section.svg" alt="Section Icon" />
                                <label class="text-wrapper-4" for="section">Section</label>
                                <input 
                                    type="text" 
                                    id="section" 
                                    class="text-wrapper-5" 
                                    v-model="form.section" 
                                    required
                                />
                                <div v-if="errors.section" class="error-message">{{ errors.section }}</div>
                            </div>
                        </div>

                        <!-- Email Input -->
                        <div class="form-group">
                            <div class="overlap-group">
                                <img class="vector" src="Assets/img/vector.svg" alt="Email Icon" />
                                <label class="text-wrapper-4" for="email">Email</label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    class="text-wrapper-5" 
                                    v-model="form.email" 
                                    required
                                />
                                <div v-if="errors.email" class="error-message">{{ errors.email }}</div>
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="form-group">
                            <div class="overlap-group">
                                <img class="vector" src="Assets/img/group.png" alt="Password Icon" />
                                <label class="text-wrapper-4" for="password">Password</label>
                                <input 
                                    :type="showPassword ? 'text' : 'password'" 
                                    id="password" 
                                    class="text-wrapper-5" 
                                    v-model="form.password" 
                                    required
                                />
                                <div v-if="errors.password" class="error-message">{{ errors.password }}</div>
                                <img 
                                    class="bi-eye-fill" 
                                    :src="showPassword ? 'Assets/img/bi-eye-slash-fill.svg' : 'Assets/img/bi-eye-fill.svg'"
                                    alt="Toggle Password Visibility" 
                                    @click="togglePassword"
                                    style="cursor: pointer;"
                                />
                            </div>
                        </div>

                        <!-- Confirm Password Input -->
                        <div class="form-group">
                            <div class="overlap-group">
                                <img class="vector" src="Assets/img/group.png" alt="Confirm Password Icon" />
                                <label class="text-wrapper-4" for="password_confirmation">Confirm Password</label>
                                <input 
                                    :type="showPassword ? 'text' : 'password'" 
                                    id="password_confirmation" 
                                    class="text-wrapper-5" 
                                    v-model="form.password_confirmation" 
                                    required
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button class="button" type="submit" :disabled="loading">
                        <div class="overlap-2">
                            <div class="rectangle-2"></div>
                            <div class="text-wrapper-7">
                                {{ loading ? 'Registering...' : 'Register' }}
                            </div>
                        </div>
                    </button>

                    <!-- Back to Login Link -->
                    <Link href="/login" class="back-to-login">
                        <div class="overlap-2">
                            <div class="rectangle-2 login">
                                <div class="text-wrapper-7">
                                    Back to Login
                                </div>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </form>
</template>

<style scoped>
/* Main form container */
.form-container {
    position: absolute;
    width: 575px;
    top: 450px;
    left: 1164px;
    display: flex;
    flex-direction: column;
    gap: 15px;
    max-height: 380px;
    overflow-y: auto;
    padding-right: 20px;
}

/* Background container */
.bg {
    position: absolute;
    width: 688px;
    height: 1000px;
    top: 42px;
    left: 1090px;
    background-color: #ffffff;
    border-radius: 15px;
    box-shadow: 0px 0px 4px #00000014;
}

/* Header positioning */
.welcome-students {
    position: absolute;
    width: 483px;
    top: 205px;
    left: 1164px;
}

/* Google login button */
.login-with-google {
    position: absolute;
    width: 581px;
    height: 70px;
    top: 348px;
    left: 1164px;
}

/* Register button */
.button {
    all: unset;
    box-sizing: border-box;
    position: absolute;
    width: 573px;
    height: 70px;
    top: 870px;
    left: 1164px;
    cursor: pointer;
}

/* Back to login button */
.back-to-login {
    position: absolute;
    width: 573px;
    height: 70px;
    top: 950px;
    left: 1164px;
    text-decoration: none;
}

/* Button styles */
.rectangle-2 {
    width: 571px;
    height: 70px;
    left: 0;
    background-color: #3182ce;
    border-radius: 8px;
    position: absolute;
    top: 0;
    transition: 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.back-to-login .rectangle-2 {
    background-color: #2563eb;
}

.back-to-login .rectangle-2:hover {
    background-color: #1d4ed8;
}

/* Form group spacing */
.form-group {
    margin-bottom: 15px;
}

/* Update the scrollbar styles */
.form-container::-webkit-scrollbar {
    width: 0;  /* Hide scrollbar but keep functionality */
    display: none;  /* Hide scrollbar completely */
}

.form-container {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}

/* Input fields */
.overlap-group {
    position: relative;
    width: 571px;
    height: 70px;
    background-color: #ebebeb;
    border-radius: 8px;
    margin-bottom: 12px;
}

.text-wrapper-4 {
    position: absolute;
    top: 15px;
    left: 82px;
    font-family: "Poppins", Helvetica;
    color: var(--black);
    font-size: 18px;
    font-weight: bold;
    letter-spacing: 0;
    line-height: 16.3px;
}

.text-wrapper-5 {
    position: absolute;
    top: 35px;
    left: 82px;
    font-family: "Poppins", Helvetica;
    color: var(--black);
    font-size: 18px;
    letter-spacing: 0;
    line-height: 21.7px;
    width: 420px;
    border: none;
    background: transparent;
    outline: none;
}

/* Button text */
.text-wrapper-7 {
    font-family: "Poppins", Helvetica;
    font-weight: 600;
    color: #ffffff;
    font-size: 1.25rem;
    letter-spacing: 0;
    line-height: 21.7px;
    white-space: nowrap;
    width: 100%;
    text-align: center;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
}

/* Error messages */
.error-message {
    color: #dc2626;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    position: absolute;
    left: 82px;
    bottom: -20px;
}

/* Select dropdown */
select.text-wrapper-5 {
    appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 1em;
    width: 420px;
    height: 35px;
}

/* Disabled button state */
.button:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.button:disabled .rectangle-2 {
    background-color: #6b7280;
}

/* Update overlap-2 styles */
.overlap-2 {
    position: relative;
    width: 571px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.group {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
}

.div {
    text-align: center;
    flex: 1;
}

.login-with-google .group {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 10px;
    width: 100%;
    margin-left: -40px;
}

.login-with-google .div {
    text-align: left;
    margin-left: -20px;
}
</style>
