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
                        <h1 class="page-title">Subject Management</h1>
                        <button class="add-button" @click="openModal()">
                            <span>Add Subject</span>
                        </button>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="frame-2">
                    <div class="table-container">
                        <!-- Table Header -->
                        <div class="table-header">
                            <div class="header-cell text-center w-16">ID</div>
                            <div class="header-cell">Subject Code</div>
                            <div class="header-cell">Subject Name</div>
                            <div class="header-cell">Grade Level</div>
                            <div class="header-cell">Strand</div>
                            <div class="header-cell text-center">Students</div>
                            <div class="header-cell text-center">Status</div>
                            <div class="header-cell text-center">Actions</div>
                        </div>

                        <!-- Table Body -->
                        <div class="table-body">
                            <div v-for="subject in filteredSubjects" :key="subject.id" class="table-row">
                                <div class="table-cell text-center">#{{ subject.id }}</div>
                                <div class="table-cell">{{ subject.code }}</div>
                                <div class="table-cell">{{ subject.name }}</div>
                                <div class="table-cell text-center">{{ subject.grade ? `Grade ${subject.grade.level}` : 'No Grade' }}</div>
                                <div class="table-cell text-center">{{ subject.strand ? subject.strand.name : 'No Strand' }}</div>
                                <div class="table-cell text-center">{{ subject.enrollment_count }}</div>
                                <div class="table-cell text-center">
                                    <span :class="['status-badge', subject.status.toLowerCase()]">
                                        {{ subject.status }}
                                    </span>
                                </div>
                                <div class="table-cell actions">
                                    <button @click="openModal(subject)" class="edit-btn">Edit</button>
                                    <button @click="deleteSubject(subject.id)" class="delete-btn">Delete</button>
                                    <button 
                                        @click="viewEnrollments(subject)" 
                                        class="view-btn"
                                        title="View Enrollments"
                                    >
                                        View
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add/Edit Modal -->
                <div v-if="showModal" class="modal-overlay">
                    <div class="modal-content">
                        <h2 class="modal-title">{{ isEditing ? 'Edit Subject' : 'Add Subject' }}</h2>
                        <form @submit.prevent="submitForm">
                            <!-- Subject Name -->
                            <div class="form-group">
                                <label for="name">Subject Name</label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    v-model="form.name" 
                                    required 
                                    placeholder="Enter subject name"
                                />
                            </div>

                            <!-- Grade Level Selection -->
                            <div class="form-group">
                                <label for="grade_id">Grade Level</label>
                                <select 
                                    id="grade_id" 
                                    v-model="form.grade_id" 
                                    required
                                    class="form-select"
                                    @change="handleGradeChange"
                                >
                                    <option value="">Select Grade Level</option>
                                    <option 
                                        v-for="grade in props.grades" 
                                        :key="grade.id" 
                                        :value="grade.id"
                                    >
                                        Grade {{ grade.level }}
                                    </option>
                                </select>
                            </div>

                            <!-- Strand Selection (Conditional) -->
                            <div class="form-group" v-if="selectedGradeLevel">
                                <label for="strand_id">
                                    Strand
                                    <span v-if="isStrandRequired" class="required-indicator">*</span>
                                    <span v-else class="optional-text">(Not Available for Grade {{ selectedGradeLevel }})</span>
                                </label>
                                <select 
                                    id="strand_id" 
                                    v-model="form.strand_id" 
                                    :required="isStrandRequired"
                                    class="form-select"
                                    :disabled="!isStrandRequired"
                                    v-show="isStrandRequired"
                                >
                                    <option value="">Select Strand</option>
                                    <template v-if="isStrandRequired">
                                        <option 
                                            v-for="strand in props.strands" 
                                            :key="strand.id" 
                                            :value="strand.id"
                                        >
                                            {{ strand.name }}
                                        </option>
                                    </template>
                                </select>
                            </div>

                            <!-- Description (Optional) -->
                            <div class="form-group">
                                <label for="description">Description (Optional)</label>
                                <textarea 
                                    id="description" 
                                    v-model="form.description" 
                                    rows="3"
                                    placeholder="Enter subject description"
                                ></textarea>
                            </div>

                            <!-- Form Actions -->
                            <div class="modal-actions">
                                <button type="submit" class="submit-btn">
                                    {{ isEditing ? 'Update' : 'Add' }} Subject
                                </button>
                                <button type="button" @click="closeModal" class="cancel-btn">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Enrollment Modal -->
                <div v-if="showEnrollmentModal" class="modal-overlay" @click.self="closeEnrollmentModal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Subject Enrollments</h2>
                            <button type="button" class="close-button" @click="closeEnrollmentModal">&times;</button>
                        </div>

                        <div class="enrollment-list">
                            <div v-if="selectedSubject?.users?.length === 0" class="no-enrollments">
                                No students enrolled yet
                            </div>
                            <div v-else v-for="enrollment in selectedSubject?.users" :key="enrollment.id" class="enrollment-item">
                                <div class="student-info">
                                    <img 
                                        :src="enrollment.image || '/Assets/img/img-teach/default-avatar.png'" 
                                        :alt="enrollment.name"
                                        class="student-avatar"
                                    />
                                    <div class="student-details">
                                        <span class="student-name">{{ enrollment.name }}</span>
                                        <span class="student-email">{{ enrollment.email }}</span>
                                    </div>
                                </div>
                                <div class="enrollment-status">
                                    <span :class="['status-badge', enrollment.pivot.status.toLowerCase()]">
                                        {{ enrollment.pivot.status }}
                                    </span>
                                    <div class="status-actions">
                                        <button 
                                            v-if="enrollment.pivot.status === 'Pending'"
                                            @click="updateEnrollmentStatus(enrollment.id, 'Approved')"
                                            class="approve-btn"
                                        >
                                            Approve
                                        </button>
                                        <button 
                                            v-if="enrollment.pivot.status === 'Pending'"
                                            @click="updateEnrollmentStatus(enrollment.id, 'Rejected')"
                                            class="reject-btn"
                                        >
                                            Reject
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    subjects: {
        type: Array,
        required: true,
        default: () => []
    },
    grades: {
        type: Array,
        required: true,
        default: () => []
    },
    strands: {
        type: Array,
        required: true,
        default: () => []
    }
});

const form = useForm({
    id: null,
    name: '',
    code: '',
    grade_id: '',
    strand_id: '',
    description: ''
});

// Page state
const isTeacherPage = false;
const isStudentPage = false;
const isSubjectPage = true; // Set this to true for the subject page
const isGradePage = false;
const isStrandPage = false;
const isDashboardPage = false;
const isSectionPage = false;

const showModal = ref(false);
const isEditing = ref(false);
const searchQuery = ref('');

const filteredSubjects = computed(() => {
    if (!searchQuery.value) return props.subjects;
    const query = searchQuery.value.toLowerCase();
    
    return props.subjects.filter(subject => {
        return subject.name.toLowerCase().includes(query) ||
               subject.grade?.level.toString().includes(query) ||
               subject.strand?.name.toLowerCase().includes(query);
    });
});

const openModal = (subject = null) => {
    form.reset();
    if (subject) {
        isEditing.value = true;
        form.id = subject.id;
        form.name = subject.name;
        form.grade_id = subject.grade_id;
        form.strand_id = subject.strand_id;
        form.description = subject.description;
    } else {
        isEditing.value = false;
    }
    showModal.value = true;
};

const selectedGradeLevel = computed(() => {
    if (!form.grade_id) return null;
    const selectedGrade = props.grades.find(grade => grade.id === parseInt(form.grade_id));
    return selectedGrade ? parseInt(selectedGrade.level) : null;
});

const isStrandRequired = computed(() => {
    return selectedGradeLevel.value >= 10;
});

const submitForm = () => {
    if (!isEditing.value) {
        form.code = form.name
            .toLowerCase()
            .replace(/[^a-z0-9]/g, '')
            .substring(0, 8) + Math.floor(Math.random() * 1000);
    }

    if (!form.grade_id) {
        Swal.fire({
            title: 'Error!',
            text: 'Please select a Grade Level',
            icon: 'error',
            timer: 2000,
            showConfirmButton: false,
            position: 'top',
            toast: true
        });
        return;
    }

    if (!isStrandRequired.value) {
        form.strand_id = null;
    }

    if (isEditing.value) {
        form.post(`/admin/subject/${form.id}/update`, {
            preserveScroll: true,
            onSuccess: () => {
                showModal.value = false;
                Swal.fire({
                    title: 'Success!',
                    text: 'Subject updated successfully',
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
        form.post('/admin/subject/store', {
            preserveScroll: true,
            onSuccess: () => {
                showModal.value = false;
                Swal.fire({
                    title: 'Success!',
                    text: 'Subject added successfully',
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

const deleteSubject = (id) => {
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
            form.delete(`/admin/subject/${id}`, {
                preserveScroll: true,
                onSuccess: () => {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Subject has been deleted.',
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
                        text: 'Failed to delete subject.',
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

const closeModal = () => {
    showModal.value = false;
    form.reset();
    isEditing.value = false;
};

const handleGradeChange = () => {
    form.strand_id = '';
    if (!isStrandRequired.value) {
        form.strand_id = null;
    }
};

// Add these refs
const showEnrollmentModal = ref(false);
const selectedSubject = ref(null);

// Add these methods
const viewEnrollments = (subject) => {
    selectedSubject.value = subject;
    showEnrollmentModal.value = true;
};

const closeEnrollmentModal = () => {
    showEnrollmentModal.value = false;
    selectedSubject.value = null;
};

const updateEnrollmentStatus = (userId, status) => {
    if (!selectedSubject.value) return;

    form.post(`/admin/subject/${selectedSubject.value.id}/enrollment/${userId}`, {
        status: status
    }, {
        preserveScroll: true,
        onSuccess: () => {
            Swal.fire({
                title: 'Success!',
                text: `Enrollment ${status.toLowerCase()} successfully`,
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
                position: 'top',
                toast: true
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
    grid-template-columns: 0.5fr 1fr 1.5fr 1fr 1fr 0.8fr 1fr 1fr;
    gap: 12px;
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
    padding: 6px 12px;
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

.colored-toast {
    margin: 1rem auto !important;
    background-color: #ffffff !important;
    color: #2d3748 !important;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
}

/* Update grid template columns to match new structure */
.table-header, .table-row {
    display: grid;
    grid-template-columns: 0.5fr 1fr 1.5fr 1fr 1fr 0.8fr 1fr 1fr;
    gap: 12px;
    padding: 16px;
    align-items: center;
}

/* Center align specific columns */
.table-cell:nth-child(3),
.table-cell:nth-child(4) {
    text-align: center;
}

/* Right align actions column */
.table-cell.actions {
    justify-content: flex-end;
}

/* Add these styles if not already present */
.header-cell {
    font-weight: 600;
    color: #4a5568;
}

.table-cell {
    display: flex;
    align-items: center;
    font-family: "Kumbh Sans", Helvetica;
    font-size: 14px;
    color: #2d3748;
}

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

/* Add to your existing styles */
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

.status-badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 9999px;
    font-size: 13px;
    font-weight: 500;
    text-align: center;
    min-width: 80px;
}

.status-badge.available {
    background-color: #def7ec;
    color: #03543f;
}

.status-badge.full {
    background-color: #fef3c7;
    color: #92400e;
}

.status-badge.closed {
    background-color: #fee2e2;
    color: #991b1b;
}

.text-center {
    text-align: center;
}

/* Add to your existing styles */
.enrollment-list {
    max-height: 400px;
    overflow-y: auto;
}

.enrollment-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px;
    border-bottom: 1px solid #e2e8f0;
}

.student-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.student-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.student-details {
    display: flex;
    flex-direction: column;
}

.student-name {
    font-weight: 500;
    color: #2d3748;
}

.student-email {
    font-size: 14px;
    color: #718096;
}

.enrollment-status {
    display: flex;
    align-items: center;
    gap: 12px;
}

.status-actions {
    display: flex;
    gap: 8px;
}

.approve-btn,
.reject-btn {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    border: none;
}

.approve-btn {
    background-color: #48bb78;
    color: white;
}

.reject-btn {
    background-color: #e53e3e;
    color: white;
}

.view-btn {
    background-color: #4299e1;
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
}

.view-btn:hover {
    background-color: #3182ce;
}

/* Add these utility classes */
.text-center {
    text-align: center;
}

.w-16 {
    width: 4rem;
}

/* Update the actions container */
.actions {
    display: flex;
    gap: 8px;
    justify-content: flex-end;
}

/* Make buttons more compact */
.edit-btn,
.delete-btn,
.view-btn {
    padding: 6px 12px;
    font-size: 13px;
}

/* Update status badge */
.status-badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 9999px;
    font-size: 13px;
    font-weight: 500;
    text-align: center;
    min-width: 80px;
}
</style>
