<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Swal from 'sweetalert2';

// Import images correctly
const backgroundImage = '/Assets/img/img-teach/background(header).png';
const dashboardIcon = '/Assets/img/img-teach/vuesax-broken-home-2-5.svg';
const teacherIcon = '/Assets/img/img-teach/vuesax-outline-teacher-3.svg';
const studentIcon = '/Assets/img/img-teach/vuesax-outline-book.svg';
const subjectIcon = '/Assets/img/img-teach/subject-icon.svg';
const settingsIcon = '/Assets/img/img-teach/vuesax-outline-setting-2-1.svg';
const notificationIcon = '/Assets/img/img-settings/vector.svg';
const lineImage = '/Assets/img/img-teach/line-34.svg';
const logoImage = '/Assets/img/img-teach/logo-1.svg';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header></template>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        

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
                                <img src="/Assets/img/img-settings/logout-icon.svg" alt="Logout" class="logout-icon" />
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
                    <div class="sidebar-m-enu">
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
                                <Link href="/admin-dashboard">
                                    <div class="frame-wrapper">
                                        <div class="frame-5">
                                            <img class="vuesax-broken-home" :src="dashboardIcon" alt="Dashboard Icon" />
                                            <div class="text-wrapper-16">Dashboard</div>
                                        </div>
                                    </div>
                                </Link>

                                <!-- Teachers Link -->
                                <Link href="/admin-teacher">
                                    <div class="frame-wrapper">
                                        <div class="frame-6">
                                            <img class="img-2" :src="teacherIcon" alt="Teachers Icon" />
                                            <div class="text-wrapper-17">Teachers</div>
                                        </div>
                                    </div>
                                </Link>

                                <!-- Students Link -->
                                <Link href="/admin-student">
                                    <div class="frame-wrapper">
                                        <div class="frame-6">
                                            <img class="img-2" :src="studentIcon" alt="Students Icon" />
                                            <div class="text-wrapper-17">Students</div>
                                        </div>
                                    </div>
                                </Link>

                                <!-- Subjects Link -->
                                <Link href="/admin-subject">
                                    <div class="frame-wrapper">
                                        <div class="frame-6">
                                            <img class="img-2" :src="subjectIcon" alt="Subjects Icon" />
                                            <div class="text-wrapper-17">Subjects</div>
                                        </div>
                                    </div>
                                </Link>

                                <!-- Settings Link -->
                                <Link href="/admin-settings">
                                    <div class="frame-wrapper">
                                        <div class="frame-6">
                                            <img class="img-2" :src="settingsIcon" alt="Settings Icon" />
                                            <div class="text-wrapper-17">Settings</div>
                                        </div>
                                    </div>
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="frame-2">
                        <div class="p-6 text-gray-900">
                            You're logged in!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

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

.logout-icon {
    width: 15px;
    height: 15px;
    filter: brightness(0) invert(1);
    transition: all 0.3s ease;
    opacity: 0.9;
}

.admin-dashboard .div-wrapper:hover .logout-icon {
    opacity: 1;
    transform: translateX(-2px);
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

/* Sidebar Styles */
.sidebar-m-enu {
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
    z-index: 10;
}

.p-6 {
    padding: 24px;
    font-size: 18px;
    color: #2d3748;
    text-align: center;
}
</style>
