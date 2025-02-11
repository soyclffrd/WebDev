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
                            <input type="search" placeholder="Search sections..." class="input-fieldtext" v-model="searchQuery">
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
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
            <Link href="/admin/dashboard">
                <div :class="['frame-wrapper', { active: isDashboardPage }]">
                    <div class="frame-5">
                        <img class="vuesax-broken-home" :src="dashboardIcon" alt="Dashboard Icon" />
                        <div class="text-wrapper-16">Dashboard</div>
                    </div>
                </div>
            </Link>

            <!-- Teachers Link -->
            <Link href="/admin/teacher">
                <div :class="['frame-wrapper', { active: isTeacherPage }]">
                    <div class="frame-6">
                        <img class="img-2" :src="teacherIcon" alt="Teachers Icon" />
                        <div class="text-wrapper-17">Teachers</div>
                    </div>
                </div>
            </Link>

            <!-- Students Link -->
            <Link href="/admin/student">
                <div :class="['frame-wrapper', { active: isStudentPage }]">
                    <div class="frame-6">
                        <img class="img-2" :src="studentIcon" alt="Students Icon" />
                        <div class="text-wrapper-17">Students</div>
                    </div>
                </div>
            </Link>

            <!-- Subjects Link -->
            <Link href="/admin/subject">
                <div :class="['frame-wrapper', { active: isSubjectPage }]">
                    <div class="frame-6">
                        <img class="img-2" :src="subjectIcon" alt="Subjects Icon" />
                        <div class="text-wrapper-17">Subjects</div>
                    </div>
                </div>
            </Link>

            <!-- Strands Link -->
            <Link href="/admin/strand">
                <div :class="['frame-wrapper', { active: isStrandPage }]">
                    <div class="frame-6">
                        <img class="img-2" :src="strandIcon" alt="Strands Icon" />
                        <div class="text-wrapper-17">Strands</div>
                    </div>
                </div>
            </Link>

            <!-- Grades Link -->
            <Link href="/admin/grades">
                <div :class="['frame-wrapper', { active: isGradePage }]">
                    <div class="frame-6">
                        <img class="img-2" :src="gradeIcon" alt="Grades Icon" />
                        <div class="text-wrapper-17">Grades</div>
                    </div>
                </div>
            </Link>

            <!-- Section Link (Active) -->
            <Link href="/admin/section">
                <div :class="['frame-wrapper', { active: isSectionPage }]">
                    <div class="frame-6">
                        <img class="img-2" :src="sectionIcon" alt="Section Icon" />
                        <div class="text-wrapper-17">Section</div>
                    </div>
                </div>
            </Link>
        </div>
    </div>
</div>


                <!-- Header Section -->
                <div class="framee">
                    <div class="header-content">
                        <h1 class="page-title">Section Management</h1>
                        <button class="add-button" @click="openModal()">
                            <span>Add Section</span>
                        </button>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="frame-2">
                    <div class="table-container">
                        <!-- Table Header -->
                        <div class="table-header">
                            <div class="header-cell">Section Name</div>
                            <div class="header-cell">Description</div>
                            <div class="header-cell">Students</div>
                            <div class="header-cell">Actions</div>
                        </div>

                        <!-- Table Body -->
                        <div class="table-body">
                            <div v-for="section in filteredSections" :key="section.id" class="table-row">
                                <div class="table-cell">{{ section.name }}</div>
                                <div class="table-cell">{{ section.description }}</div>
                                <div class="table-cell student-count">
                                    {{ section.students?.length || 0 }} Students
                                </div>
                                <div class="table-cell actions">
                                    <button class="edit-btn" @click="openModal(section)">Edit</button>
                                    <button class="delete-btn" @click="deleteSection(section.id)">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add/Edit Modal -->
                <div v-if="showModal" class="modal-overlay">
                    <div class="modal-content">
                        <h2 class="modal-title">{{ isEditing ? 'Edit Section' : 'Add Section' }}</h2>
                        <form @submit.prevent="submitForm">
                            <div class="form-group">
                                <label for="name">Section Name</label>
                                <input type="text" id="name" v-model="form.name" required />
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" v-model="form.description" rows="3"></textarea>
                            </div>
                            <div class="modal-actions">
                                <button type="submit" class="submit-btn">
                                    {{ isEditing ? 'Update' : 'Add' }} Section
                                </button>
                                <button type="button" @click="showModal = false" class="cancel-btn">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import { ref, computed } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

// Import images correctly
const backgroundImage = '/Assets/img/img-teach/background(header).png';
const dashboardIcon = '/Assets/img/img-teach/vuesax-broken-home-2-5.svg';
const teacherIcon = '/Assets/img/img-teach/teacher-icon.svg';
const studentIcon = '/Assets/img/img-teach/student-icon.svg';
const subjectIcon = '/Assets/img/img-teach/subject-icon.svg';
const strandIcon = '/Assets/img/img-teach/strand-icon.svg';
const gradeIcon = '/Assets/img/img-teach/grade-icon.svg';
const sectionIcon = '/Assets/img/img-teach/section-icon.svg';
const notificationIcon = '/Assets/img/img-settings/vector.svg';
const lineImage = '/Assets/img/img-teach/line-34.svg';
const logoImage = '/Assets/img/img-teach/logo-1.svg';

const props = defineProps({
    sections: Array
});

// Page state
const isTeacherPage = false;
const isStudentPage = false;
const isSubjectPage = false;
const isGradePage = false;
const isStrandPage = false;
const isDashboardPage = false;
const isSectionPage = true; // Set this to true for the section page


const form = useForm({
    id: null,
    name: '',
    description: ''
});

const showModal = ref(false);
const isEditing = ref(false);
const searchQuery = ref('');

const filteredSections = computed(() => {
    if (!searchQuery.value) return props.sections;
    const query = searchQuery.value.toLowerCase();
    return props.sections.filter(section => {
        return section.name.toLowerCase().includes(query) ||
               section.description.toLowerCase().includes(query);
    });
});

const openModal = (section = null) => {
    form.reset();
    if (section) {
        isEditing.value = true;
        form.id = section.id;
        form.name = section.name;
        form.description = section.description;
    } else {
        isEditing.value = false;
    }
    showModal.value = true;
};

const submitForm = () => {
    if (isEditing.value) {
        form.post(`/admin/section/${form.id}/update`, {
            preserveScroll: true,
            onSuccess: () => {
                showModal.value = false;
                Swal.fire({
                    title: 'Success!',
                    text: 'Section updated successfully',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false,
                    position: 'top',
                    toast: true,
                    customClass: {
                        popup: 'colored-toast'
                    }
                });
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
    } else {
        form.post('/admin/section/store', {
            preserveScroll: true,
            onSuccess: () => {
                showModal.value = false;
                Swal.fire({
                    title: 'Success!',
                    text: 'Section added successfully',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false,
                    position: 'top',
                    toast: true,
                    customClass: {
                        popup: 'colored-toast'
                    }
                });
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
    }
};

const deleteSection = (id) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3182ce',
        cancelButtonColor: '#e53e3e',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(`/admin/section/${id}`, {
                preserveScroll: true,
                onSuccess: () => {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Section has been deleted.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        position: 'top',
                        toast: true,
                        customClass: {
                            popup: 'colored-toast'
                        }
                    });
                },
                onError: () => {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to delete section.',
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false,
                        position: 'top',
                        toast: true
                    });
                }
            });
        }
    });
};
</script>


<style scoped>
/* Reuse styles from teacher.vue */
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
    font-size: 32px;
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
    font-size: 16px;
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
    padding: 24px;
    margin: 0;
    width: 100%;
    height: 620px;
    overflow-y: auto;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    background-color: white;
}

.table-header, .table-row {
    display: grid;
    grid-template-columns: 2fr 3fr 1fr 1fr;
    gap: 20px;
    padding: 16px;
    align-items: center;
}

.table-header {
    background-color: #f8fafc;
    border-radius: 8px;
    margin-bottom: 8px;
    font-size: 18px;
    font-weight: 600;
    color: #2d3748;
}

.table-row {
    border-bottom: 1px solid #e2e8f0;
}

.table-row:hover {
    background-color: #f8fafc;
}

.actions {
    display: flex;
    gap: 8px;
    justify-content: flex-end;
}

.edit-btn,
.delete-btn {
    padding: 8px 16px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-weight: 500;
    transition: background-color 0.2s;
}

.edit-btn {
    background-color: #3182ce;
    color: white;
}

.edit-btn:hover {
    background-color: #2c5282;
}

.delete-btn {
    background-color: #e53e3e;
    color: white;
}

.delete-btn:hover {
    background-color: #c53030;
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
    padding: 32px;
    width: 100%;
    max-width: 500px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.modal-title {
    font-family: "Kumbh Sans", Helvetica;
    font-size: 24px;
    font-weight: 600;
    color: #1a202c;
    margin-bottom: 24px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-family: "Kumbh Sans", Helvetica;
    font-size: 14px;
    font-weight: 500;
    color: #4a5568;
    margin-bottom: 8px;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-family: "Kumbh Sans", Helvetica;
    font-size: 14px;
    color: #2d3748;
    transition: all 0.3s ease;
}

.form-group input:focus,
.form-group textarea:focus {
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
    padding: 10px 20px;
    border-radius: 6px;
    font-family: "Kumbh Sans", Helvetica;
    font-size: 14px;
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
    font-size: 24px;
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

.frame-wrapper.active {
    background-color: #3182ce;
}

.frame-wrapper.active .text-wrapper-17 {
    color: #ffffff;
}

.frame-wrapper.active .img-2 {
    filter: brightness(0) invert(1);
}

.frame-5,
.frame-6 {
    display: flex;
    align-items: center;
    gap: 16px;
}

.vuesax-broken-home,
.img-2 {
    width: 24px;
    height: 24px;
}

.text-wrapper-16,
.text-wrapper-17 {
    font-family: "Kumbh Sans", Helvetica;
    font-size: 16px;
    font-weight: 500;
    color: #4a5568;
}


/* Add these styles to your existing styles */
.colored-toast.swal2-icon-success {
    background-color: #48bb78 !important;
    color: white !important;
}

.colored-toast.swal2-icon-error {
    background-color: #f56565 !important;
    color: white !important;
}

.colored-toast .swal2-title {
    color: white !important;
}

.colored-toast .swal2-close {
    color: white !important;
}

.colored-toast .swal2-html-container {
    color: white !important;
}

/* Add to your existing styles */
.student-count {
    color: #4A5568;
    font-weight: 500;
    text-align: center;
}
</style>
