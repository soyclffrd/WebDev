<template>
  <div class="admin-dashboard">
    <div class="div">
      <div class="overlap">
        <img class="background" :src="backgroundImage" alt="Background" />

        <!-- Top Menu Section -->
        <div class="frame">
          <div class="iconoir-bell">
            <div class="overlap-group">
              <img class="vector" :src="notificationIcon" alt="Notification Icon" />
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
                  <img class="icon" src="/Assets/img/img-settings/icon.svg" alt="Search Icon" />
                </div>
              </div>
              <input type="search" placeholder="Type here..." class="input-fieldtext" />
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
              <!-- Dashboard Link (Active) -->
              <div class="subjectsfinal active">
                <div class="frame-wrapper">
                  <div class="frame-6">
                    <img class="img-2" :src="dashboardIcon" alt="Dashboard Icon" />
                    <div class="text-wrapper-17">Dashboard</div>
                  </div>
                </div>
              </div>

              <!-- Other Menu Items -->
              <Link v-for="stat in statistics" :key="stat.title" :href="stat.link">
                <div class="frame-wrapper">
                  <div class="frame-6">
                    <img class="img-2" :src="stat.icon" :alt="stat.title" />
                    <div class="text-wrapper-17">{{ stat.title }}</div>
                  </div>
                </div>
              </Link>
            </div>
          </div>
        </div>

        <!-- Header Section -->
        <div class="framee">
          <div class="header-content">
            <h1 class="page-title">Dashboard Overview</h1>
          </div>
        </div>

        <!-- Main Content -->
        <div class="frame-2">
          <div class="dashboard-content">
            <!-- Statistics Cards -->
            <div class="statistics-grid">
              <div v-for="stat in statistics" :key="stat.title" 
                   class="stat-card" 
                   :style="{ borderColor: stat.color }">
                <div class="stat-icon" :style="{ backgroundColor: stat.color }">
                  <img :src="stat.icon" :alt="stat.title" />
                </div>
                <div class="stat-content">
                  <h3>{{ stat.title }}</h3>
                  <p class="stat-count">{{ stat.count }}</p>
                  <Link :href="stat.link" class="stat-link">View Details →</Link>
                </div>
              </div>
            </div>

            <!-- Additional Dashboard Content -->
            <div class="dashboard-sections">
              <!-- Recent Activity Section -->
              <div class="dashboard-section">
                <h2>Recent Activity</h2>
                <ul class="activity-list">
                  <li v-for="activity in recentActivities" :key="activity.id">
                    <span class="activity-time">{{ activity.time }}</span>
                    <span class="activity-description">{{ activity.description }}</span>
                  </li>
                </ul>
              </div>

              <!-- Quick Stats Section -->
              <div class="dashboard-section">
                <h2>Quick Stats</h2>
                <ul class="quick-stats-list">
                  <li v-for="stat in quickStats" :key="stat.label">
                    <span class="stat-label">{{ stat.label }}</span>
                    <span class="stat-value">{{ stat.value }}</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    teachers: {
        type: Number,
        required: true
    },
    students: {
        type: Number,
        required: true
    },
    subjects: {
        type: Number,
        required: true
    },
    strands: {
        type: Number,
        required: true
    },
    grades: {
        type: Number,
        required: true
    }
});


// Import images correctly
const backgroundImage = '/Assets/img/img-teach/background(header).png';
const dashboardIcon = '/Assets/img/img-teach/vuesax-broken-home-2-5.svg';
const teacherIcon = '/Assets/img/img-teach/vuesax-outline-teacher-3.svg';
const studentIcon = '/Assets/img/img-teach/vuesax-outline-book.svg';
const subjectIcon = '/Assets/img/img-teach/subject-icon.svg';
const strandIcon = '/Assets/img/img-teach/strand-icon.svg';
const gradeIcon = '/Assets/img/img-teach/grade-icon.svg';
const notificationIcon = '/Assets/img/img-settings/vector.svg';
const lineImage = '/Assets/img/img-teach/line-34.svg';
const logoImage = '/Assets/img/img-teach/logo-1.svg';

// Compute statistics
const statistics = computed(() => [
    {
        title: 'Teachers',
        count: props.teachers,
        icon: teacherIcon,
        link: '/admin/teacher',
        color: '#3182CE'
    },
    {
        title: 'Students',
        count: props.students,
        icon: studentIcon,
        link: '/admin/student',
        color: '#48BB78'
    },
    {
        title: 'Subjects',
        count: props.subjects,
        icon: subjectIcon,
        link: '/admin/subject',
        color: '#ED8936'
    },
    {
        title: 'Strands',
        count: props.strands,
        icon: strandIcon,
        link: '/admin/strand',
        color: '#9F7AEA'
    },
    {
        title: 'Grades',
        count: props.grades,
        icon: gradeIcon,
        link: '/admin/grades',
        color: '#F56565'
    }
]);

// Sample data for Recent Activity and Quick Stats
const recentActivities = ref([
  { id: 1, time: '10:00 AM', description: 'Teacher John Doe added a new subject.' },
  { id: 2, time: '11:30 AM', description: 'Student Jane Smith enrolled in Math 101.' },
  { id: 3, time: '1:00 PM', description: 'Grade 10 results published.' },
]);

const quickStats = computed(() => [
  { label: 'Total Teachers', value: props.teachers?.length || 0 },
  { label: 'Total Students', value: props.students?.length || 0 },
  { label: 'Total Subjects', value: props.subjects?.length || 0 },
  { label: 'Total Strands', value: props.strands?.length || 0 },
  { label: 'Total Grades', value: props.grades?.length || 0 },
]);
</script>

<style scoped>
.admin-dashboard {
  background-color: #f7fafc;
  display: flex;
  flex-direction: row;
  justify-content: center;
  width: 100%;
}

.div {
  background-color: var(--graygray-50);
  overflow: hidden;
  width: 1920px;
  height: 1229px;
  position: relative;
}

.overlap {
  position: absolute;
  width: 1920px;
  height: 1213px;
  top: 0;
  left: 0;
}

.background {
  position: absolute;
  width: 1920px;
  height: 421px;
  top: 0;
  left: 0;
  object-fit: cover;
}

.frame {
  position: absolute;
  width: 1491px;
  height: 95px;
  top: 0;
  left: 429px;
}

.iconoir-bell {
  position: absolute;
  width: 28px;
  height: 28px;
  top: 40px;
  left: 1292px;
}

.overlap-group {
  position: relative;
  width: 24px;
  height: 26px;
  left: 3px;
}

.vector {
  position: absolute;
  width: 24px;
  height: 25px;
  top: 2px;
  left: 0;
}

.ellipse {
  position: absolute;
  width: 13px;
  height: 13px;
  top: 0;
  left: 11px;
  background-color: #16ea1a;
  border-radius: 6.3px;
  transform: rotate(180deg);
}

.div-wrapper {
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

.div-wrapper:hover {
  background-color: #2c5282;
  transform: translateY(-2px);
  box-shadow: 0 6px 8px -1px rgba(49, 130, 206, 0.2),
              0 4px 6px -1px rgba(49, 130, 206, 0.1);
  border-color: rgba(255, 255, 255, 0.1);
}

.div-wrapper:active {
  transform: translateY(1px);
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.text-wrapper {
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

.menu {
  position: absolute;
  width: 204px;
  height: 43px;
  top: 33px;
  left: 1070px;
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

.auto-added-frame {
  display: flex;
  padding: 12px;
  align-items: flex-start;
  gap: 10px;
  position: relative;
}

.addon {
  position: relative;
  width: 16px;
  height: 16px;
}

.icon {
  position: absolute;
  width: 16px;
  height: 16px;
  top: 0;
  left: 0;
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
  top: 140px;
  left: 320px;
  right: 40px;
  display: flex;
  align-items: center;
  padding: 20px;
  background-color: rgba(255, 255, 255, 0.9);
  border-radius: 12px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.header-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
}

.page-title {
  font-size: 32px;
  font-weight: 600;
  color: #1a202c;
  margin: 0;
  order: 1;
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

.dashboard-content {
  padding: 24px;
  height: 620px;
  overflow-y: auto;
}

.statistics-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 24px;
  margin-bottom: 32px;
}

.stat-card {
  background: white;
  border-radius: 12px;
  padding: 24px;
  display: flex;
  align-items: center;
  gap: 20px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
  border-left: 4px solid;
  transition: all 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.stat-icon {
  width: 60px;
  height: 60px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.stat-icon img {
  width: 32px;
  height: 32px;
  filter: brightness(0) invert(1);
}

.stat-content h3 {
  font-size: 18px;
  font-weight: 600;
  color: #2D3748;
  margin: 0 0 8px 0;
}

.stat-count {
  font-size: 32px;
  font-weight: 700;
  color: #1A202C;
  margin: 0 0 12px 0;
}

.stat-link {
  color: #3182CE;
  text-decoration: none;
  font-weight: 500;
  font-size: 14px;
  display: inline-flex;
  align-items: center;
  gap: 4px;
}

.stat-link:hover {
  text-decoration: underline;
}

.dashboard-sections {
  margin-top: 140px;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 24px;
}

.dashboard-section {
  background: white;
  border-radius: 12px;
  padding: 24px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.dashboard-section h2 {
  font-size: 20px;
  font-weight: 600;
  color: #2D3748;
  margin: 0 0 16px 0;
}

.activity-list,
.quick-stats-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.activity-list li,
.quick-stats-list li {
  margin-bottom: 12px;
  display: flex;
  justify-content: space-between;
}

.activity-time,
.stat-label {
  font-weight: 600;
  color: #4A5568;
}

.activity-description,
.stat-value {
  color: #2D3748;
}

/* Sidebar Styles */
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

.subjectsfinal {
  border-radius: 12px;
  transition: all 0.2s ease;
}

.subjectsfinal.active {
  background-color: #3182ce;
  box-shadow: 0 4px 6px -1px rgba(49, 130, 206, 0.1), 
              0 2px 4px -1px rgba(49, 130, 206, 0.06);
}

.subjectsfinal.active .text-wrapper-17 {
  color: #ffffff;
  font-weight: 600;
}

.subjectsfinal.active .img-2 {
  filter: brightness(0) invert(1);
}

.vuesax-broken-home,
.img-2 {
  width: 22px;
  height: 22px;
  object-fit: contain;
}

.text-wrapper-16,
.text-wrapper-17 {
  font-family: "Kumbh Sans", Helvetica;
  font-size: 16px;
  font-weight: 500;
  color: #4a5568;
  white-space: nowrap;
}

.frame-wrapper:hover .text-wrapper-16,
.frame-wrapper:hover .text-wrapper-17 {
  color: #3182ce;
}

.frame-wrapper:hover .img-2,
.frame-wrapper:hover .vuesax-broken-home {
  transform: scale(1.1);
}
</style>
