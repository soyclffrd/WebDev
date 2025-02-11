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
                            <Link href="/user-dashboard">
                                <div class="frame-wrapper">
                                    <div class="frame-5">
                                        <img class="vuesax-broken-home" :src="dashboardIcon" alt="Dashboard Icon" />
                                        <div class="text-wrapper-16">Dashboard</div>
                                    </div>
                                </div>
                            </Link>

                            <!-- My Subjects Link (Active) -->
                            <div class="subjectsfinal active">
                                <div class="frame-wrapper">
                                    <div class="frame-6">
                                        <img class="img-2" :src="subjectIcon" alt="Subjects Icon" />
                                        <div class="text-wrapper-17">My Subjects</div>
                                    </div>
                                </div>
                            </div>

                            <!-- My Teachers Link -->
                            <Link href="/user/teachers">
                                <div class="frame-wrapper">
                                    <div class="frame-6">
                                        <img class="img-2" :src="teacherIcon" alt="Teachers Icon" />
                                        <div class="text-wrapper-17">My Teachers</div>
                                    </div>
                                </div>
                            </Link>

                            <!-- My Grades Link -->
                            <Link href="/user/grades">
                                <div class="frame-wrapper">
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
                    </div>
                </div>

                <!-- Main Content -->
                <div class="frame-2">
                    <div class="table-container">
                        <!-- Table Header -->
                        <div class="table-header">
                            <div class="header-cell">Subject Name</div>
                            <div class="header-cell">Teacher</div>
                            <div class="header-cell">Schedule</div>
                            <div class="header-cell">Status</div>
                        </div>

                        <!-- Table Body -->
                        <div class="table-body">
                            <div v-for="subject in filteredSubjects" :key="subject.id" class="table-row">
                                <div class="table-cell">{{ subject.name }}</div>
                                <div class="table-cell">
                                    <div class="teacher-info">
                                        <img 
                                            :src="subject.teacher?.image || '/Assets/img/img-teach/default-avatar.png'" 
                                            :alt="subject.teacher?.name"
                                            class="teacher-image"
                                        >
                                        <span>{{ subject.teacher?.name || 'Not Assigned' }}</span>
                                    </div>
                                </div>
                                <div class="table-cell">{{ subject.schedule || 'TBA' }}</div>
                                <div class="table-cell">
                                    <span :class="['status-badge', subject.status]">
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
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';

// Import images correctly
const backgroundImage = '/Assets/img/img-teach/background(header).png';
const dashboardIcon = '/Assets/img/img-teach/vuesax-broken-home-2-5.svg';
const teacherIcon = '/Assets/img/img-teach/vuesax-outline-teacher-3.svg';
const subjectIcon = '/Assets/img/img-teach/subject-icon.svg';
const gradeIcon = '/Assets/img/img-teach/grade-icon.svg';
const notificationIcon = '/Assets/img/img-settings/vector.svg';
const lineImage = '/Assets/img/img-teach/line-34.svg';
const logoImage = '/Assets/img/img-teach/logo-1.svg';

const props = defineProps({
    subjects: {
        type: Array,
        required: true,
        default: () => []
    }
});

const searchQuery = ref('');

const filteredSubjects = computed(() => {
    if (!searchQuery.value) return props.subjects;
    const query = searchQuery.value.toLowerCase();
    
    return props.subjects.filter(subject => {
        return subject.name.toLowerCase().includes(query) ||
               subject.teacher?.name.toLowerCase().includes(query) ||
               subject.schedule?.toLowerCase().includes(query);
    });
});
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
    grid-template-columns: 2fr 2fr 1fr 1fr;
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

/* Status Badge Styles */
.status-badge {
    padding: 6px 12px;
    border-radius: 9999px;
    font-size: 14px;
    font-weight: 500;
    text-transform: capitalize;
    display: inline-block;
}

.status-badge.active {
    background-color: #C6F6D5;
    color: #2F855A;
}

.status-badge.pending {
    background-color: #FEEBC8;
    color: #C05621;
}

.status-badge.completed {
    background-color: #E9D8FD;
    color: #6B46C1;
}

/* Teacher Info Styles */
.teacher-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.teacher-image {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e2e8f0;
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

.frame-5,
.frame-6 {
    display: flex;
    align-items: center;
    gap: 16px;
}

.subjectsfinal.active .frame-wrapper {
    background-color: #3182ce;
}

.subjectsfinal.active .text-wrapper-17 {
    color: #ffffff;
}

.subjectsfinal.active .img-2 {
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
    font-size: 16px;
    font-weight: 500;
    color: #4a5568;
}

/* Responsive Styles */
@media (max-width: 1536px) {
    .admin-dashboard .div {
        width: 100%;
    }

    .frame-2 {
        left: 300px;
    }

    .framee {
        left: 300px;
    }
}

@media (max-width: 1280px) {
    .table-header, .table-row {
        grid-template-columns: 2fr 2fr 1fr 1fr;
        gap: 10px;
    }
}

@media (max-width: 1024px) {
    .admin-dashboard .frame {
        width: calc(100% - 300px);
        left: 300px;
    }
}

@media (max-width: 768px) {
    .table-header, .table-row {
        grid-template-columns: 1fr 1fr 1fr 1fr;
        font-size: 14px;
    }

    .teacher-image {
        width: 28px;
        height: 28px;
    }
}
</style>
