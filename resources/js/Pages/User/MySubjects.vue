<template>
    <div class="admin-dashboard">
        <div class="div">
            <div class="overlap">
                <img class="background" :src="backgroundImage" alt="Background" />

                <!-- Top Menu Section -->
                <div class="frame">
                    <div class="iconoir-bell">
                        <div class="overlap-group">
                            <img class="vector" :src="notificationIcon" alt="Notification Icon">
                            <div class="ellipse"></div>
                        </div>
                    </div>
                    <Link href="/logout" method="post" as="button">
                        <div class="div-wrapper">
                            <button class="text-wrapper">Log out</button>
                        </div>
                    </Link>
                    <div class="menu">
                        <div class="input-withaddons">
                            <div class="auto-added-frame">
                                <div class="addon">
                                    <img class="icon" src="/Assets/img/img-settings/icon.svg" alt="Search Icon">
                                </div>
                            </div>
                            <input type="search" placeholder="Search subjects..." class="input-fieldtext" v-model="searchQuery">
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <div class="sidebar-menu">
                    <div class="overlap-7">
                        <!-- Logo and School Name Section -->
                        <div class="header-section">
                            <div class="logo" :style="{ backgroundImage: `url(${logoImage})` }"></div>
                            <div class="frame-9">
                                <div class="text-wrapper-19">Surigao City NHS</div>
                            </div>
                            <img class="line" :src="lineImage" alt="Line Divider" />
                        </div>

                        <!-- Menu Items Section -->
                        <div class="frame-4">
                            <!-- Dashboard Link -->
                            <Link href="/user/dashboard">
                                <div :class="['frame-wrapper', { active: isDashboardPage }]">
                                    <div class="frame-5">
                                        <img class="vuesax-broken-home" :src="dashboardIcon" alt="Dashboard Icon" />
                                        <div class="text-wrapper-16">Dashboard</div>
                                    </div>
                                </div>
                            </Link>

                            <!-- My Subjects Link (Active) -->
                            <div :class="['frame-wrapper', { active: isMySubjectsPage }]">
                                <div class="frame-6">
                                    <img class="img-2" :src="subjectIcon" alt="Subjects Icon" />
                                    <div class="text-wrapper-17">My Subjects</div>
                                </div>
                            </div>

                            <!-- My Grades Link -->
                            <Link href="/user/grades">
                                <div :class="['frame-wrapper', { active: isGradesPage }]">
                                    <div class="frame-6">
                                        <img class="img-2" :src="gradeIcon" alt="Grades Icon" />
                                        <div class="text-wrapper-17">My Grades</div>
                                    </div>
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Header Section -->
                <div class="framee">
                    <div class="header-content">
                        <h1 class="page-title">My Subjects</h1>
                        <!-- <button class="add-button" @click="openModal()">
                            <span>Add Subject</span>
                        </button> -->
                    </div>
                </div>

                <!-- Main Content -->
                <div class="frame-2">
                    <div class="table-container">
                        <!-- Table Header -->
                        <div class="table-header">
                            <div class="header-cell">ID</div>
                            <div class="header-cell">Subject Code</div>
                            <div class="header-cell">Subject Name</div>
                            <div class="header-cell">Teacher</div>
                            <div class="header-cell">Schedule</div>
                            <div class="header-cell">Status</div>
                            <div class="header-cell">Actions</div>
                        </div>

                        <!-- Table Body -->
                        <div class="table-body">
                            <div v-if="availableSubjects.length === 0" class="no-content">
                                <div class="no-content-wrapper">
                                    <img 
                                        src="/Assets/img/img-teach/empty-box.svg" 
                                        alt="No Subjects" 
                                        class="empty-icon"
                                    />
                                    <h3 class="no-content-title">No Subjects Yet</h3>
                                    <p class="no-content-text">
                                        Click the "Add Subject" button to request enrollment in subjects.<br>
                                        Your requests will be pending until approved by admin.
                                    </p>
                                    <button class="add-subject-btn" @click="openModal()">
                                        <span class="plus-icon">+</span>
                                        Add Subject
                                    </button>
                                </div>
                            </div>
                            <div v-else v-for="subject in enrolledSubjects" :key="subject.id" class="table-row">
                                <div class="table-cell">#{{ subject.id }}</div>
                                <div class="table-cell">{{ subject.code }}</div>
                                <div class="table-cell">{{ subject.name }}</div>
                                <div class="table-cell">{{ subject.teacher?.name || 'Not Assigned' }}</div>
                                <div class="table-cell">{{ subject.schedule || 'TBA' }}</div>
                                <div class="table-cell">
                                    <span class="status" :class="subject.status.toLowerCase()">
                                        {{ subject.status }}
                                    </span>
                                </div>
                                <div class="table-cell actions">
                                    <button 
                                        v-if="subject.status === 'Not Enrolled'"
                                        @click="enrollSubject(subject.id)"
                                        class="enroll-btn"
                                    >
                                        Enroll
                                    </button>
                                    <button 
                                        v-else-if="subject.status === 'Enrolled'"
                                        @click="dropSubject(subject.id)"
                                        class="drop-btn"
                                    >
                                        Drop
                                    </button>
                                    <span v-else class="pending-status">
                                        {{ subject.status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this modal component -->
    <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Select Subject</h2>
                <button 
                    type="button" 
                    class="close-button" 
                    @click="closeModal"
                    aria-label="Close modal"
                >
                    &times;
                </button>
            </div>
            <form @submit.prevent="submitForm">
                <div class="form-group">
                    <label for="subject">Available Subjects</label>
                    <select 
                        id="subject" 
                        v-model="form.subject_id" 
                        required
                        class="form-select"
                    >
                        <option value="">Select a Subject</option>
                        <option 
                            v-for="subject in availableSubjects" 
                            :key="subject.id" 
                            :value="subject.id"
                            :disabled="subject.available_slots <= 0"
                        >
                            {{ subject.code }} - {{ subject.name }}
                            ({{ subject.teacher?.name || 'No Teacher' }})
                            [{{ subject.available_slots }} slots available]
                        </option>
                    </select>
                    <div v-if="selectedSubject" class="subject-details">
                        <p class="subject-info">
                            <span class="label">Grade Level:</span>
                            {{ selectedSubject.grade?.level }}
                        </p>
                        <p class="subject-info">
                            <span class="label">Schedule:</span>
                            {{ selectedSubject.schedule || 'TBA' }}
                        </p>
                        <p class="subject-info">
                            <span class="label">Available Slots:</span>
                            {{ selectedSubject.available_slots }}
                        </p>
                    </div>
                </div>

                <div class="modal-actions">
                    <button 
                        type="submit" 
                        class="submit-btn"
                        :disabled="!form.subject_id"
                    >
                        Request Enrollment
                    </button>
                    <button type="button" @click="closeModal" class="cancel-btn">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

// Import images
const backgroundImage = '/Assets/img/img-teach/background(header).png';
const dashboardIcon = '/Assets/img/img-teach/vuesax-broken-home-2-5.svg';
const subjectIcon = '/Assets/img/img-teach/subject-icon.svg';
const gradeIcon = '/Assets/img/img-teach/grade-icon.svg';
const notificationIcon = '/Assets/img/img-settings/vector.svg';
const lineImage = '/Assets/img/img-teach/line-34.svg';
const logoImage = '/Assets/img/img-teach/logo-1.svg';

const props = defineProps({
    availableSubjects: {
        type: Array,
        required: true,
        default: () => []
    },
    enrolledSubjects: {
        type: Array,
        required: true,
        default: () => []
    },
    user: {
        type: Object,
        required: true
    }
});

// Page state
const isDashboardPage = ref(false);
const isMySubjectsPage = ref(true);
const isGradesPage = ref(false);
const searchQuery = ref('');
const showModal = ref(false);
const form = useForm({
    subject_id: ''
});

// Update the computed property for filtering available subjects
const filteredSubjects = computed(() => {
    if (!searchQuery.value) return props.availableSubjects;
    
    const query = searchQuery.value.toLowerCase();
    return props.availableSubjects.filter(subject => {
        return subject.code.toLowerCase().includes(query) ||
               subject.name.toLowerCase().includes(query) ||
               subject.teacher?.name.toLowerCase().includes(query);
    });
});

const enrollSubject = (subjectId) => {
    Swal.fire({
        title: 'Confirm Enrollment',
        text: 'Do you want to enroll in this subject?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, enroll',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            useForm().post(`/user/subjects/${subjectId}/enroll`, {
                onSuccess: () => {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Enrollment request submitted',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        }
    });
};

const dropSubject = (subjectId) => {
    Swal.fire({
        title: 'Confirm Drop',
        text: 'Are you sure you want to drop this subject?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, drop',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#dc3545'
    }).then((result) => {
        if (result.isConfirmed) {
            useForm().post(`/user/subjects/${subjectId}/drop`, {
                onSuccess: () => {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Drop request submitted',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        }
    });
};

const openModal = () => {
    showModal.value = true;
    form.reset();
};

const closeModal = () => {
    showModal.value = false;
    form.reset();
};

const submitForm = () => {
    form.post(`/user/subjects/${form.subject_id}/enroll`, {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            Swal.fire({
                title: 'Success!',
                text: 'Enrollment request submitted successfully',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
                position: 'top',
                toast: true,
                customClass: {
                    popup: 'colored-toast'
                }
            });
            window.location.reload();
        },
        onError: (errors) => {
            Swal.fire({
                title: 'Error!',
                text: Object.values(errors)[0],
                icon: 'error',
                timer: 2000,
                showConfirmButton: false,
                position: 'top',
                toast: true
            });
        }
    });
};

const selectedSubject = computed(() => {
    if (!form.subject_id) return null;
    return props.availableSubjects.find(subject => subject.id === form.subject_id);
});
</script>

<style scoped>
/* Copy all styles from teacher.vue and add/modify these specific styles */

/* Subject Card Styles */
.subjects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    padding: 24px;
}

.subject-card {
    background: white;
    border-radius: 8px;
    padding: 1.5rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.subject-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.status {
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.875rem;
    font-weight: 500;
}

.status.enrolled {
    background-color: #def7ec;
    color: #03543f;
}

.status.pending {
    background-color: #fef3c7;
    color: #92400e;
}

.status.not.enrolled {
    background-color: #fee2e2;
    color: #991b1b;
}

.subject-details {
    margin-bottom: 1.5rem;
}

.subject-actions {
    display: flex;
    justify-content: flex-end;
}

.enroll-btn, .drop-btn {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.enroll-btn {
    background-color: #3182ce;
    color: white;
    border: none;
}

.enroll-btn:hover {
    background-color: #2c5282;
}

.drop-btn {
    background-color: #e53e3e;
    color: white;
    border: none;
}

.drop-btn:hover {
    background-color: #c53030;
}

.pending-status {
    color: #92400e;
    font-weight: 500;
}

/* Add all other styles from teacher.vue here */
/* Reuse styles from Grades.vue */
.admin-dashboard {
    background-color: #f7fafc;
    display: flex;
    flex-direction: row;
    justify-content: center;
    width: 100%;
}

.admin-dashboard .div {
    background-color: var(--graygray-50);
    overflow: hidden;
    width: 1920px;
    height: 1229px;
    position: relative;
}

.admin-dashboard .overlap {
    position: absolute;
    width: 1920px;
    height: 1213px;
    top: 0;
    left: 0;
}

.admin-dashboard .background {
    position: absolute;
    width: 1920px;
    height: 421px;
    top: 0;
    left: 0;
    object-fit: cover;
}

.admin-dashboard .frame {
    position: absolute;
    width: 1491px;
    height: 95px;
    top: 0;
    left: 429px;
}

.admin-dashboard .iconoir-bell {
    position: absolute;
    width: 28px;
    height: 28px;
    top: 40px;
    left: 1292px;
}

.admin-dashboard .overlap-group {
    position: relative;
    width: 24px;
    height: 26px;
    left: 3px;
}

.admin-dashboard .vector {
    position: absolute;
    width: 24px;
    height: 25px;
    top: 2px;
    left: 0;
}

.admin-dashboard .ellipse {
    position: absolute;
    width: 13px;
    height: 13px;
    top: 0;
    left: 11px;
    background-color: #16ea1a;
    border-radius: 6.3px;
    transform: rotate(180deg);
}

.admin-dashboard .div-wrapper {
    display: flex;
    width: 120px;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 12px 24px;
    position: absolute;
    top: 34px;
    left: 1330px;
    background-color: #3182ce;
    border-radius: 8px;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.admin-dashboard .div-wrapper:hover {
    background-color: #2c5282;
    transform: translateY(-2px);
    box-shadow: 0 6px 8px -1px rgba(49, 130, 206, 0.2),
                0 4px 6px -1px rgba(49, 130, 206, 0.1);
    border-color: rgba(255, 255, 255, 0.1);
}

.admin-dashboard .div-wrapper:active {
    transform: translateY(1px);
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.admin-dashboard .text-wrapper {
    position: relative;
    font-family: "Kumbh Sans", Helvetica;
    font-weight: 600;
    color: #ffffff;
    font-size: 16px;
    letter-spacing: 0.5px;
    text-transform: none;
    background: none;
    border: none;
    padding: 0;
    margin: 0;
    cursor: pointer;
    display: flex;
    align-items: center;
    white-space: nowrap;
}

.admin-dashboard .menu {
    position: absolute;
    width: 204px;
    height: 43px;
    top: 33px;
    left: 1070px;
}

.admin-dashboard .input-withaddons {
    display: flex;
    width: 204px;
    height: 43px;
    align-items: center;
    position: relative;
    background-color: var(--blackampwhitewhite);
    border-radius: 8px;
    overflow: hidden;
    border: 0.5px solid;
    border-color: var(--graygray-200);
}

.admin-dashboard .auto-added-frame {
    display: flex;
    padding: 12px;
    align-items: flex-start;
    gap: 10px;
    position: relative;
}

.admin-dashboard .addon {
    position: relative;
    width: 16px;
    height: 16px;
}

.admin-dashboard .icon {
    position: absolute;
    width: 16px;
    height: 16px;
}

.input-fieldtext {
    border: none;
    outline: none;
    padding: 8px;
    width: 100%;
    font-family: "Kumbh Sans", Helvetica;
}

/* Header Styles */
.framee {
    position: absolute;
    top: 130px;
    left: 320px;
    right: 40px;
    z-index: 20;
    display: flex;
    align-items: center;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.page-title {
    font-family: "Kumbh Sans", Helvetica;
    font-size: 36px;
    font-weight: 600;
    color: #1a202c;
    margin: 0;
}

.add-button {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background-color: #3182ce;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.add-button:hover {
    background-color: #2c5282;
}

.add-button span {
    color: #ffffff;
    font-family: "Kumbh Sans", Helvetica;
    font-size: 18px;
    font-weight: 500;
}

.add-icon {
    width: 20px;
    height: 20px;
}

/* Main Content Styles */
.frame-2 {
    position: absolute;
    top: 230px;
    left: 320px;
    right: 40px;
    background-color: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.table-container {
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    margin: 24px;
    overflow: hidden;
    height: 610px;
}

.table-header {
    display: grid;
    grid-template-columns: 0.5fr 1fr 2fr 1.5fr 1fr 1fr 1fr;
    background-color: #f8fafc;
    padding: 16px;
    border-bottom: 1px solid #e2e8f0;
}

.table-row {
    display: grid;
    grid-template-columns: 0.5fr 1fr 2fr 1.5fr 1fr 1fr 1fr;
    padding: 16px;
    border-bottom: 1px solid #e2e8f0;
    align-items: center;
}

.header-cell {
    font-weight: 600;
    color: #4a5568;
    font-size: 16px;
}

.table-cell {
    font-size: 16px;
    color: #2d3748;
}

.status {
    padding: 6px 14px;
    border-radius: 9999px;
    font-size: 14px;
    font-weight: 500;
    display: inline-block;
}

.status.enrolled {
    background-color: #def7ec;
    color: #03543f;
}

.status.pending {
    background-color: #fef3c7;
    color: #92400e;
}

.status.not.enrolled {
    background-color: #fee2e2;
    color: #991b1b;
}

.actions {
    display: flex;
    gap: 8px;
    justify-content: flex-end;
}

.enroll-btn,
.drop-btn {
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    border: none;
    transition: all 0.2s;
}

.enroll-btn {
    background-color: #3182ce;
    color: white;
}

.enroll-btn:hover {
    background-color: #2c5282;
}

.drop-btn {
    background-color: #e53e3e;
    color: white;
}

.drop-btn:hover {
    background-color: #c53030;
}

.pending-status {
    color: #92400e;
    font-weight: 500;
    font-size: 14px;
}

/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background-color: #ffffff;
    border-radius: 12px;
    padding: 40px;
    width: 100%;
    max-width: 600px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.modal-title {
    font-family: "Kumbh Sans", Helvetica;
    font-size: 32px;
    font-weight: 600;
    color: #1a202c;
    margin-bottom: 28px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-family: "Kumbh Sans", Helvetica;
    font-size: 18px;
    font-weight: 500;
    color: #4a5568;
    margin-bottom: 10px;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 14px 18px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-family: "Kumbh Sans", Helvetica;
    font-size: 18px;
    color: #2d3748;
    transition: all 0.3s ease;
}

.form-group input:focus,
.form-group select:focus {
    outline: none;
    border-color: #3182ce;
    box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
}

.modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 24px;
}

.submit-btn,
.cancel-btn {
    padding: 14px 28px;
    border-radius: 6px;
    font-family: "Kumbh Sans", Helvetica;
    font-size: 18px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.submit-btn {
    background-color: #3182ce;
    color: #ffffff;
    border: none;
}

.submit-btn:hover {
    background-color: #2c5282;
}

.cancel-btn {
    background-color: #e2e8f0;
    color: #4a5568;
    border: none;
}

.cancel-btn:hover {
    background-color: #cbd5e0;
}

/* Sidebar Menu Styles */
.sidebar-menu {
    position: fixed;
    width: 300px;
    height: 100vh;
    top: 0;
    left: 0;
    background-color: #ffffff;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
    z-index: 40;
}

.overlap-7 {
    position: relative;
    height: 100%;
    background-color: #ffffff;
    display: flex;
    flex-direction: column;
    padding: 0;
}

.header-section {
    padding: 20px 0;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.logo {
    width: 80px;
    height: 80px;
    margin: 20px auto 10px;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
}

.frame-9 {
    text-align: center;
    margin: 10px 0 20px;
}

.text-wrapper-19 {
    font-family: "Kumbh Sans", Helvetica;
    font-size: 28px;
    font-weight: 600;
    color: #1a202c;
}

.line {
    width: 100%;
    height: 1px;
    background-color: #e2e8f0;
    margin: 0;
}

.frame-4 {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: 24px 16px;
    margin-top: 0;
}

.frame-wrapper {
    padding: 12px 16px;
    border-radius: 12px;
    transition: all 0.2s ease;
    margin: 4px 0;
}

.frame-wrapper:hover {
    background-color: #f7fafc;
    transform: translateX(5px);
}
/* Add these to your existing styles */
.frame-wrapper.active {
    background-color: #3182ce;
}

.frame-wrapper.active .text-wrapper-16,
.frame-wrapper.active .text-wrapper-17 {
    color: #ffffff;
}

.frame-wrapper.active .vuesax-broken-home,
.frame-wrapper.active .img-2 {
    filter: brightness(0) invert(1);
}

/* Update the hover styles */
.frame-wrapper:hover {
    background-color: #f7fafc;
    transform: translateX(5px);
}

.frame-wrapper:hover .text-wrapper-16,
.frame-wrapper:hover .text-wrapper-17 {
    color: #3182ce;
}

.frame-wrapper:hover .vuesax-broken-home,
.frame-wrapper:hover .img-2 {
    transform: scale(1.1);
}


.frame-5,
.frame-6 {
    display: flex;
    align-items: center;
    gap: 16px;
}

.teachersfinal.active .frame-wrapper {
    background-color: #3182ce;
}

.teachersfinal.active .text-wrapper-17 {
    color: #ffffff;
}

.teachersfinal.active .img-2 {
    filter: brightness(0) invert(1);
}

.vuesax-broken-home,
.img-2 {
    width: 24px;
    height: 24px;
}

.text-wrapper-16,
.text-wrapper-17 {
    font-family: "Kumbh Sans", Helvetica;
    font-size: 18px;
    font-weight: 500;
    color: #4a5568;
}

/* Add these new styles */
.teacher-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.teacher-image {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e2e8f0;
}

.colored-toast {
    margin: 1rem auto !important;
    background-color: #ffffff !important;
    color: #2d3748 !important;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
}

/* Update table styles for image column */
.table-header, .table-row {
    display: grid;
    grid-template-columns: 0.5fr 1fr 2fr 1.5fr 1fr 1fr 1fr;
    padding: 16px;
    align-items: center;
}

/* Center align specific columns */
.table-cell:nth-child(1), /* ID */
.table-cell:nth-child(5), /* Schedule */
.table-cell:nth-child(6) { /* Status */
    justify-content: center;
    text-align: center;
}

/* Right align actions column */
.table-cell:last-child {
    justify-content: flex-end;
}

/* Add these styles for better spacing */
.table-cell {
    padding: 0 8px;
}

/* Make status badges more compact */
.status {
    padding: 6px 14px;
    font-size: 14px;
}

/* Make action buttons more compact */
.enroll-btn, .drop-btn {
    padding: 8px 16px;
    font-size: 14px;
}

/* Add to your existing styles */
.help-text {
    font-size: 16px;
    color: #718096;
    margin-top: 8px;
    line-height: 1.5;
}

.form-select {
    width: 100%;
    padding: 14px 18px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 18px;
    color: #2d3748;
}

.form-select option:disabled {
    font-size: 16px;
    color: #a0aec0;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.close-button {
    background: none;
    border: none;
    font-size: 2rem;
    color: #4a5568;
    cursor: pointer;
    padding: 8px;
}

.close-button:hover {
    color: #2d3748;
}

/* Add to your existing styles */
.no-content {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 500px;
    width: 100%;
    padding: 2rem;
}

.no-content-wrapper {
    text-align: center;
    max-width: 500px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.empty-icon {
    width: 150px;
    height: 150px;
    margin-bottom: 2rem;
    opacity: 0.7;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.no-content-title {
    font-family: "Kumbh Sans", Helvetica;
    font-size: 32px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 1.5rem;
}

.no-content-text {
    font-family: "Kumbh Sans", Helvetica;
    font-size: 18px;
    color: #718096;
    line-height: 1.6;
    margin-bottom: 2.5rem;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

.add-subject-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 28px;
    background-color: #3182ce;
    color: white;
    border: none;
    border-radius: 8px;
    font-family: "Kumbh Sans", Helvetica;
    font-size: 18px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.add-subject-btn:hover {
    background-color: #2c5282;
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(49, 130, 206, 0.2);
}

.add-subject-btn:active {
    transform: translateY(1px);
}

.plus-icon {
    font-size: 20px;
    font-weight: 600;
    line-height: 1;
    margin-right: 4px;
}

.subject-details {
    margin-top: 16px;
    padding: 16px;
    background-color: #f7fafc;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.subject-info {
    margin: 8px 0;
    font-size: 14px;
    color: #4a5568;
}

.subject-info .label {
    font-weight: 500;
    color: #2d3748;
    margin-right: 8px;
}

.form-select {
    width: 100%;
    padding: 12px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    color: #2d3748;
    background-color: white;
}

.form-select option:disabled {
    color: #a0aec0;
    font-style: italic;
}
</style>