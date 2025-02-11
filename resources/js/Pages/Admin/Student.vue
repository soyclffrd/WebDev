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
                            <input type="search" :placeholder="searchPlaceholder" class="input-fieldtext" v-model="searchQuery">
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

                            <!-- Students Link (Active) -->
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

                            <!-- Section Link -->
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
                        <h1 class="page-title">{{ pageTitle }}</h1>
                        <button class="add-button" @click="openModal()">
                            <span>{{ addButtonLabel }}</span>
                        </button>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="frame-2">
                    <div class="table-container">
                        <!-- Table Header -->
                        <div class="table-header">
                            <div class="header-cell">ID</div>
                            <div class="header-cell">Name</div>
                            <div class="header-cell">Email</div>
                            <div class="header-cell">Grade Level</div>
                            <div class="header-cell">Strand</div>
                            <div class="header-cell">Section</div>
                            <div class="header-cell">Actions</div>
                        </div>

                        <!-- Table Body -->
                        <div class="table-body">
                            <div v-for="student in filteredItems" :key="student.id" class="table-row">
                                <div class="table-cell">#{{ student.id }}</div>
                                <div class="table-cell">
                                    <div class="student-info">
                                        <img 
                                            :src="student.image ? student.image : '/Assets/img/img-teach/default-avatar.png'" 
                                            :alt="student.name"
                                            class="student-image"
                                        >
                                        <span>{{ student.name }}</span>
                                    </div>
                                </div>
                                <div class="table-cell">{{ student.email }}</div>
                                <div class="table-cell">{{ student.grade ? `Grade ${student.grade.level}` : 'No Grade' }}</div>
                                <div class="table-cell">{{ student.strand ? student.strand.name : 'No Strand' }}</div>
                                <div class="table-cell">
                                    {{ student.section ? student.section.name : 'No Section' }}
                                </div>
                                <div class="table-cell actions">
                                    <button class="edit-btn" @click="openModal(student)">Edit</button>
                                    <button class="delete-btn" @click="deleteStudent(student.id)">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add/Edit Modal -->
                <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">{{ isEditing ? 'Edit Student' : 'Add Student' }}</h2>
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
                            <div v-for="field in formFields" :key="field.id" class="form-group">
                                <label :for="field.id">{{ field.label }}</label>
                                
                                <!-- Select Input -->
                                <select 
                                    v-if="field.type === 'select'"
                                    :id="field.id"
                                    v-model="form[field.model]"
                                    :required="field.required"
                                    class="form-select"
                                >
                                    <option value="">Select {{ field.label }}</option>
                                    <option 
                                        v-for="option in field.options" 
                                        :key="option.id" 
                                        :value="option.id"
                                    >
                                        {{ option.name }}
                                    </option>
                                </select>

                                <!-- File Input -->
                                <input 
                                    v-else-if="field.inputType === 'file'"
                                    :type="field.inputType"
                                    :id="field.id"
                                    :accept="field.accept"
                                    @change="field.onChange"
                                    class="form-input"
                                >

                                <!-- Text Input -->
                                <input 
                                    v-else
                                    :type="field.inputType || 'text'"
                                    :id="field.id"
                                    v-model="form[field.model]"
                                    :required="field.required"
                                    class="form-input"
                                >
                            </div>

                            <div class="modal-actions">
                                <button type="submit" class="submit-btn">
                                    {{ isEditing ? 'Update' : 'Add' }} Student
                                </button>
                                <button type="button" @click="closeModal" class="cancel-btn">
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

// Import images
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

// Define props
const props = defineProps({
    students: {
        type: Array,
        required: true,
        default: () => []
    },
    strands: {
        type: Array,
        required: true,
        default: () => []
    },
    grades: {
        type: Array,
        required: true,
        default: () => []
    },
    sections: {
        type: Array,
        required: true,
        default: () => []
    }
});

// Page state
const pageTitle = 'Student Management';
const addButtonLabel = 'Add Student';
const searchPlaceholder = 'Search students...';
const isTeacherPage = false;
const isStudentPage = true;
const isSubjectPage = false;
const isGradePage = false;
const isStrandPage = false;
const isDashboardPage = false;
const isSectionPage = false;

// Form and modal state
const showModal = ref(false);
const isEditing = ref(false);
const searchQuery = ref('');
const imagePreview = ref(null);

// Initialize form with all required fields
const form = useForm({
    id: null,
    name: '',
    email: '',
    grade_id: '',
    strand_id: '',
    section_id: '',
    gender: '',
    image: null
});

// Handle image upload
const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.image = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

// Form fields configuration
const formFields = [
    { 
        id: 'name', 
        label: 'Name', 
        type: 'text', 
        model: 'name',
        required: true,
        placeholder: 'Enter student name'
    },
    { 
        id: 'email', 
        label: 'Email', 
        type: 'email', 
        model: 'email',
        required: true,
        placeholder: 'Enter student email'
    },
    { 
        id: 'grade_id', 
        label: 'Grade Level', 
        type: 'select', 
        model: 'grade_id',
        required: true, 
        options: props.grades.map(grade => ({
            id: grade.id,
            name: `Grade ${grade.level}`
        }))
    },
    { 
        id: 'strand_id', 
        label: 'Strand', 
        type: 'select', 
        model: 'strand_id',
        required: true, 
        options: props.strands 
    },
    { 
        id: 'section_id', 
        label: 'Section', 
        type: 'select', 
        model: 'section_id',
        required: true, 
        options: props.sections.map(section => ({
            id: section.id,
            name: section.name
        }))
    },
    { 
        id: 'gender', 
        label: 'Gender', 
        type: 'select', 
        model: 'gender',
        required: true,
        options: [
            { id: 'Male', name: 'Male' },
            { id: 'Female', name: 'Female' }
        ]
    },
    { 
        id: 'image', 
        label: 'Profile Image', 
        type: 'file',
        inputType: 'file',
        model: 'image',
        required: false,
        accept: 'image/*',
        onChange: handleImageUpload
    }
];

// Filter students
const filteredItems = computed(() => {
    if (!searchQuery.value) return props.students;
    const query = searchQuery.value.toLowerCase();
    
    return props.students.filter(student => {
        return student.name.toLowerCase().includes(query) ||
               student.email.toLowerCase().includes(query) ||
               (student.grade && `Grade ${student.grade.level}`.toLowerCase().includes(query)) ||
               student.strand?.name.toLowerCase().includes(query) ||
               student.section?.toLowerCase().includes(query) ||
               student.gender?.toLowerCase().includes(query);
    });
});

// Add/Edit modal functions
const openModal = (student = null) => {
    form.reset();
    imagePreview.value = null;
    
    if (student) {
        isEditing.value = true;
        form.id = student.id;
        form.name = student.name;
        form.email = student.email;
        form.grade_id = student.grade_id;
        form.strand_id = student.strand_id;
        form.section_id = student.section_id;
        form.gender = student.gender;
        imagePreview.value = student.image;
    } else {
        isEditing.value = false;
    }
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    form.reset();
    imagePreview.value = null;
    isEditing.value = false;
};

// Form submission for both add and edit
const submitForm = () => {
    if (isEditing.value) {
        form.post(`/admin/student/${form.id}/update`, {
            preserveScroll: true,
            onSuccess: () => {
                closeModal(); // Close the modal
                Swal.fire({
                    title: 'Success!',
                    text: 'Student updated successfully',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false,
                    position: 'top',
                    toast: true,
                    customClass: {
                        popup: 'colored-toast'
                    }
                });
                window.location.reload(); // Refresh the page
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
        form.post('/admin/student/store', {
            preserveScroll: true,
            onSuccess: () => {
                closeModal(); // Close the modal
                Swal.fire({
                    title: 'Success!',
                    text: 'Student added successfully',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false,
                    position: 'top',
                    toast: true,
                    customClass: {
                        popup: 'colored-toast'
                    }
                });
                window.location.reload(); // Refresh the page
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

// Delete function
const deleteStudent = (id) => {
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
            form.delete(`/admin/student/${id}`, {
                preserveScroll: true,
                onSuccess: () => {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Student has been deleted.',
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
                onError: (error) => {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to delete student.',
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

// Form validation helper
const validateForm = () => {
    if (!form.name || !form.email || !form.grade_id || !form.strand_id || !form.section_id || !form.gender) {
        Swal.fire({
            title: 'Error!',
            text: 'Please fill in all required fields',
            icon: 'error',
            timer: 2000,
            showConfirmButton: false,
            position: 'top',
            toast: true
        });
        return false;
    }
    return true;
};

// Add these computed properties
const selectedGradeLevel = computed(() => {
    if (!form.grade_id) return null;
    const selectedGrade = props.grades.find(grade => grade.id === parseInt(form.grade_id));
    return selectedGrade ? parseInt(selectedGrade.level) : null;
});

const isStrandRequired = computed(() => {
    return selectedGradeLevel.value >= 10;
});

// Add grade change handler
const handleGradeChange = () => {
    form.strand_id = '';  // Reset strand selection
    if (!isStrandRequired.value) {
        form.strand_id = null;  // Set to null for grades below 10
    }
};
</script>

<style scoped>
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
    grid-template-columns: 0.5fr 2fr 1.5fr 1fr 1fr 1fr 1fr;
    gap: 16px;
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
    z-index: 9999;
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
.form-group select {
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

/* Active Menu Item */
.frame-wrapper.active {
    background-color: #3182ce;
}

.frame-wrapper.active .text-wrapper-17 {
    color: #ffffff;
}

.frame-wrapper.active .img-2 {
    filter: brightness(0) invert(1);
}

/* Add these styles */
.form-input,
.form-select {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-input[type="file"] {
    padding: 6px;
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: #3182ce;
    box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
}

.modal-overlay {
    background-color: rgba(0, 0, 0, 0.5);
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 50;
}

.modal-content {
    background-color: white;
    padding: 2rem;
    border-radius: 8px;
    width: 100%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
}

/* Add these new styles */
.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.close-button {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #4a5568;
    cursor: pointer;
    padding: 0.5rem;
    line-height: 1;
    transition: color 0.2s;
}

.close-button:hover {
    color: #2d3748;
}

/* Table Styles */
.table-container {
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.table-header {
    display: grid;
    grid-template-columns: 0.5fr 2fr 1.5fr 1fr 1fr 1fr 1fr;
    background-color: #f8fafc;
    padding: 16px;
    border-bottom: 1px solid #e2e8f0;
}

.header-cell {
    font-family: "Kumbh Sans", Helvetica;
    font-size: 14px;
    font-weight: 600;
    color: #4a5568;
}

.table-body {
    max-height: calc(100vh - 300px);
    overflow-y: auto;
}

.table-row {
    display: grid;
    grid-template-columns: 0.5fr 2fr 1.5fr 1fr 1fr 1fr 1fr;
    padding: 16px;
    border-bottom: 1px solid #e2e8f0;
    transition: background-color 0.2s;
}

.table-row:hover {
    background-color: #f7fafc;
}

.table-cell {
    display: flex;
    align-items: center;
    font-family: "Kumbh Sans", Helvetica;
    font-size: 14px;
    color: #2d3748;
}

.student-info {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 200px;
}

.student-image {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e2e8f0;
}

.actions {
    display: flex;
    gap: 8px;
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

/* ID column */
.table-cell:nth-child(1) {
    color: #718096;
    font-weight: 500;
}

/* Name column with image */
.student-info {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 200px;
}

.student-image {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e2e8f0;
}

/* Email column */
.table-cell:nth-child(3) {
    color: #4A5568;
}

/* Grade Level column */
.table-cell:nth-child(4) {
    justify-content: center;
}

/* Strand column */
.table-cell:nth-child(5) {
    justify-content: center;
}

/* Section column */
.table-cell:nth-child(6) {
    justify-content: center;
}

/* Actions column */
.table-cell.actions {
    justify-content: flex-end;
    gap: 8px;
}

/* Header cells alignment */
.table-header .header-cell {
    font-family: "Kumbh Sans", Helvetica;
    font-size: 14px;
    font-weight: 600;
    color: #4a5568;
}

.table-header .header-cell:nth-child(4),
.table-header .header-cell:nth-child(5),
.table-header .header-cell:nth-child(6) {
    text-align: center;
}

.table-header .header-cell:last-child {
    text-align: right;
}

/* Add to your style section */
.image-upload-container {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.image-preview {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid #e2e8f0;
    margin-top: 8px;
}

.preview-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.form-input[type="file"] {
    padding: 8px;
    border: 1px dashed #e2e8f0;
    border-radius: 6px;
    cursor: pointer;
}

.form-input[type="file"]:hover {
    border-color: #3182ce;
}

/* Add these styles for the select input */
.form-select {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-family: "Kumbh Sans", Helvetica;
    font-size: 14px;
    color: #2d3748;
    background-color: white;
    cursor: pointer;
    transition: all 0.3s ease;
}

.form-select:focus {
    outline: none;
    border-color: #3182ce;
    box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
}

.form-select option {
    padding: 8px;
}

/* Add these styles */
.required-indicator {
    color: #e53e3e;
    margin-left: 4px;
}

.optional-text {
    color: #718096;
    font-size: 0.875rem;
    font-weight: normal;
    margin-left: 4px;
}

.form-select:disabled {
    background-color: #f7fafc;
    cursor: not-allowed;
}
</style>