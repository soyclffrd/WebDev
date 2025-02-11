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
                            <input type="search" placeholder="Search grades..." class="input-fieldtext" v-model="searchQuery">
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

                            <!-- My Subjects Link -->
                            <Link href="/user/my-subjects">
                                <div :class="['frame-wrapper', { active: isMySubjectsPage }]">
                                    <div class="frame-6">
                                        <img class="img-2" :src="subjectIcon" alt="Subjects Icon" />
                                        <div class="text-wrapper-17">My Subjects</div>
                                    </div>
                                </div>
                            </Link>

                            <!-- My Grades Link (Active) -->
                            <div :class="['frame-wrapper', { active: isGradesPage }]">
                                <div class="frame-6">
                                    <img class="img-2" :src="gradeIcon" alt="Grades Icon" />
                                    <div class="text-wrapper-17">My Grades</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Header Section -->
                <div class="framee">
                    <div class="header-content">
                        <h1 class="page-title">My Grades</h1>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="frame-2">
                    <div class="table-container">
                        <!-- Table Header -->
                        <div class="table-header">
                            <div class="header-cell">Subject Code</div>
                            <div class="header-cell">Subject Name</div>
                            <div class="header-cell">Teacher</div>
                            <div class="header-cell text-center">Midterm</div>
                            <div class="header-cell text-center">Finals</div>
                            <div class="header-cell text-center">Final Grade</div>
                            <div class="header-cell text-center">Remarks</div>
                        </div>

                        <!-- Table Body -->
                        <div class="table-body">
                            <div v-if="grades.length === 0" class="no-content">
                                <div class="no-content-wrapper">
                                    <img 
                                        src="/Assets/img/img-teach/empty-box.svg" 
                                        alt="No Grades" 
                                        class="empty-icon"
                                    />
                                    <h3 class="no-content-title">No Grades Available</h3>
                                    <p class="no-content-text">
                                        Your grades will appear here once they are submitted by your teachers.
                                    </p>
                                </div>
                            </div>
                            <div v-else v-for="grade in grades" :key="grade.id" class="table-row">
                                <div class="table-cell">{{ grade.subject.code }}</div>
                                <div class="table-cell">{{ grade.subject.name }}</div>
                                <div class="table-cell">{{ grade.subject.teacher?.name || 'Not Assigned' }}</div>
                                <div class="table-cell text-center font-medium">
                                    {{ grade.midterm || 'N/A' }}
                                </div>
                                <div class="table-cell text-center font-medium">
                                    {{ grade.finals || 'N/A' }}
                                </div>
                                <div class="table-cell text-center font-medium">
                                    {{ grade.final_grade || 'N/A' }}
                                </div>
                                <div class="table-cell text-center">
                                    <span :class="['status', getRemarkClass(grade.remarks)]">
                                        {{ grade.remarks || 'Pending' }}
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
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

// Import images
const backgroundImage = '/Assets/img/img-teach/background(header).png';
const dashboardIcon = '/Assets/img/img-teach/vuesax-broken-home-2-5.svg';
const subjectIcon = '/Assets/img/img-teach/subject-icon.svg';
const gradeIcon = '/Assets/img/img-teach/grade-icon.svg';
const notificationIcon = '/Assets/img/img-settings/vector.svg';
const lineImage = '/Assets/img/img-teach/line-34.svg';
const logoImage = '/Assets/img/img-teach/logo-1.svg';

const props = defineProps({
    grades: {
        type: Array,
        required: true,
        default: () => []
    }
});

// Page state
const isDashboardPage = ref(false);
const isMySubjectsPage = ref(false);
const isGradesPage = ref(true);
const searchQuery = ref('');

// Helper function for remarks styling
const getRemarkClass = (remarks) => {
    if (!remarks) return 'pending';
    switch (remarks.toLowerCase()) {
        case 'passed':
            return 'passed';
        case 'failed':
            return 'failed';
        default:
            return 'pending';
    }
};
</script>

<style scoped>
/* Copy all styles from MySubjects.vue */
/* Add these grade-specific styles */

/* Update grid template for grades table */
.table-header, .table-row {
    display: grid;
    grid-template-columns: 1fr 2fr 1.5fr 1fr 1fr 1fr 1fr;
    padding: 16px;
    align-items: center;
    gap: 8px;
}

/* Add text alignment classes */
.text-center {
    text-align: center;
    justify-content: center;
}

.font-medium {
    font-weight: 500;
}

/* Update status badge styles */
.status {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 9999px;
    font-size: 14px;
    font-weight: 500;
    text-align: center;
    min-width: 90px;
}

.status.passed {
    background-color: #def7ec;
    color: #03543f;
}

.status.failed {
    background-color: #fee2e2;
    color: #991b1b;
}

.status.pending {
    background-color: #fef3c7;
    color: #92400e;
}

/* Add hover effect on rows */
.table-row:hover {
    background-color: #f7fafc;
}

/* Add cell padding */
.table-cell {
    padding: 0 8px;
}

/* Style header cells */
.header-cell {
    font-weight: 600;
    color: #4a5568;
    font-size: 16px;
}

/* Add all other styles from MySubjects.vue here */

/* Add these styles from MySubjects.vue */
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

.input-withaddons {
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

.input-fieldtext {
    border: none;
    outline: none;
    padding: 8px;
    width: 100%;
    font-family: "Kumbh Sans", Helvetica;
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
    font-size: 18px;
    font-weight: 500;
    color: #4a5568;
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

/* Empty State Styles */
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
</style>
