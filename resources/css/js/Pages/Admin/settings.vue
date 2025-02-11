<script setup>
  import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="admin-dashboard">
        <div class="div">
            <div class="overlap">
                <img class="background" src="/Assets/img/img-settings/background(header).png" alt="Background">

                <!-- Top Menu Section -->
                <div class="frame">
                    <div class="iconoir-bell">
                        <div class="overlap-group">
                            <img class="vector" src="/Assets/img/img-settings/vector.svg" alt="Notification Icon">
                            <div class="ellipse"></div>
                        </div>
                    </div>
                    <Link href=" login ">
                      <div class="div-wrapper">
                        <button class="text-wrapper" onclick="logout()">Log out</button>
                    </div>
                    </Link>
                    
                    <div class="menu">
                        <div class="input-withaddons">
                            <div class="auto-added-frame">
                                <div class="addon">
                                    <img class="icon" src="/Assets/img/img-settings/icon.svg" alt="Search Icon">
                                </div>
                            </div>
                            <input type="search" placeholder="Type here..." class="input-fieldtext">
                        </div>
                    </div>
                </div>

                <!-- Profile Section -->
                <div class="frame-2">
                  <div class="container rounded bg-white mt-1 mb-5">
                    <div class="row">
                        <div class="col-md-4 border-right">
                            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="190px" src="Assets/img/img-settings/ellipse-1.png"><span class="font-weight-bold" style="font-size: 24px;">Edogaru</span><span class="text-black-50" style="font-size: 18px;">edogaru@mail.com.my</span><span> </span></div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-15 py-5">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="text-right">Profile Settings</h4>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6"><label class="labels">Name</label><input type="text" class="form-control" placeholder="first name" value=""></div>
                                    <div class="col-md-6"><label class="labels">Surname</label><input type="text" class="form-control" value="" placeholder="surname"></div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12"><label class="labels">Mobile Number</label><input type="text" class="form-control" placeholder="enter phone number" value=""></div>
                                    <div class="col-md-12"><label class="labels">Address Line 1</label><input type="text" class="form-control" placeholder="enter address line 1" value=""></div>
                                    <div class="col-md-12"><label class="labels">Address Line 2</label><input type="text" class="form-control" placeholder="enter address line 2" value=""></div>
                                    <div class="col-md-12"><label class="labels">Postcode</label><input type="text" class="form-control" placeholder="enter address line 2" value=""></div>
                                    <div class="col-md-12"><label class="labels">State</label><input type="text" class="form-control" placeholder="enter address line 2" value=""></div>
                                    <div class="col-md-12"><label class="labels">Area</label><input type="text" class="form-control" placeholder="enter address line 2" value=""></div>
                                    <div class="col-md-12"><label class="labels">Email ID</label><input type="text" class="form-control" placeholder="enter email id" value=""></div>
                                    <div class="col-md-12"><label class="labels">Education</label><input type="text" class="form-control" placeholder="education" value=""></div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6"><label class="labels">Country</label><input type="text" class="form-control" placeholder="country" value=""></div>
                                    <div class="col-md-6"><label class="labels">State/Region</label><input type="text" class="form-control" value="" placeholder="state"></div>
                                </div>
                                <div class="mt-5 "><button class="btn btn-primary profile-button" type="button">Save Profile</button></div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                </div>
                </div> 

                <!-- Sidebar Menu -->
                <div class="sidebar-m-enu">
                    <div class="overlap-7">
                        <div class="frame-4">
                            <!-- Dashboard Link -->
                            <div class="frame-wrapper">
                              <Link href="/admin-dashboard">
                                <div class="frame-5">
                                    <img class="vuesax-broken-home" src="/Assets/img/img-settings/vuesax-broken-home-2-5.svg" alt="Dashboard Icon">
                                    <div class="text-wrapper-16">Dashboard</div>
                                </div>
                              </Link>
                            </div>
                            <!-- Teachers Link -->
                            <div class="frame-wrapper">
                              <Link href="/admin-teacher">
                                <div class="frame-6">
                                    <img class="img-2" src="/Assets/img/img-settings/vuesax-broken-home-2-6.svg" alt="Teachers Icon">
                                    <div class="text-wrapper-17">Teachers</div>
                                </div>
                              </Link>
                            </div>
                            <!-- Students Link -->
                            <div class="frame-wrapper">
                              <Link href="/admin-student">
                                <div class="frame-6">
                                    <img class="img-2" src="/Assets/img/img-settings/vuesax-outline-teacher-3.svg" alt="Students Icon">
                                    <div class="text-wrapper-17">Students</div>
                                </div>
                              </Link>
                            </div>
                            <!-- Settings Link -->
                            <div class="frame-7">
                                <div class="frame-8">
                                    <img class="img-2" src="/Assets/img/img-settings/vuesax-outline-setting-2-3.svg" alt="Settings Icon">
                                    <div class="text-wrapper-18">Settings</div>
                                </div>
                            </div>
                        </div>
                        <div class="logo"></div>
                        <div class="frame-9">
                            <div class="text-wrapper-19">Surigao City NHS</div>
                        </div>
                        <img class="line" src="/Assets/img/img-settings/line-34.svg" alt="Line Divider">
                    </div>
                </div>
            </div>
            <img class="rectangle-9" src="/Assets/img/img-settings/rectangle-1470.png" alt="Footer Decoration">
</template>

 <!-- JavaScript for Button Actions -->
 <script>
 function logout() {
     alert("Logging out...");
     // Logic for logging out
 }
 
 function saveChanges() {
     alert("Changes saved successfully.");
     // Logic to save changes
 }
 
 function cancelChanges() {
     alert("Changes canceled.");
     // Logic to cancel changes
 }
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
}

.admin-dashboard .frame {
  position: absolute;
  width: 1491px;
  height: 95px;
  top: 0;
  left: 429px;
}

.admin-dashboard .row {
  background-color: none;
  width: 950px;
  
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
  padding: 10px;
  position: absolute;
  top: 34px;
  left: 1338px;
  background-color: var(--projectsecondary-300);
  border-radius: 8px;
  transition: ease-in-out;
}
.admin-dashboard .div-wrapper:hover {
  background-color: #175086;
}

.admin-dashboard .text-wrapper {
  position: relative;
  width: fit-content;
  margin-top: -0.5px;
  font-family: "Kumbh Sans", Helvetica;
  font-weight: 600;
  color: #fbf9f9;
  font-size: 20px;
  text-align: center;
  letter-spacing: 0;
  line-height: normal;
  background: none;
  border: none;
  outline: none;
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
  width: 37.5px;
  align-items: center;
  justify-content: center;
  position: relative;
  align-self: stretch;
}

.admin-dashboard .addon {
  display: flex;
  width: 32px;
  height: 25px;
  align-items: center;
  gap: 5px;
  padding: 4px 6px;
  position: relative;
}

.admin-dashboard .icon {
  position: relative;
  width: 15px;
  height: 15px;
}

.admin-dashboard .input-fieldtext {
  display: inline-flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: center;
  position: relative;
  flex: 0 0 auto;
  overflow: hidden;
  outline: none;
  border: none;
}

.admin-dashboard .text-wrapper-2 {
  position: relative;
  width: 102px;
  height: 23px;
  margin-top: -0.5px;
  font-family: "Kumbh Sans", Helvetica;
  font-weight: 400;
  color: var(--graygray-400);
  font-size: 16px;
  letter-spacing: 0;
  line-height: 24px;
  white-space: nowrap;
}

.admin-dashboard .min-width {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0px 74px;
  position: relative;
  flex: 0 0 auto;
}

.admin-dashboard .content {
  position: relative;
  width: 1px;
  height: 1px;
  margin-right: -0.99px;
}

.admin-dashboard .frame-2 {
  position: absolute;
  width: 1542px;
  height: 1110px;
  top: 100px;
  left: 334px;
  background-color: #ffffff;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0px 5px 14px #0000001a;
}
.form-control:focus {
  box-shadow: none;
  border-color: #BA68C8
}

.profile-button {
  background: rgb(99, 39, 120);
  box-shadow: none;
  border: none
}

.profile-button:hover {
  background: #682773
}

.profile-button:focus {
  background: #682773;
  box-shadow: none
}

.profile-button:active {
  background: #682773;
  box-shadow: none
}

.back:hover {
  color: #682773;
  cursor: pointer
}

.labels {
  font-size: 11px
}

.add-experience:hover {
  background: #BA68C8;
  color: #fff;
  cursor: pointer;
  border: solid 1px #BA68C8
}

.admin-dashboard .overlap-2 {
  position: absolute;
  width: 325px;
  height: 206px;
  top: 199px;
  left: 267px;
}

.admin-dashboard .frame-3 {
  position: absolute;
  width: 325px;
  height: 30px;
  top: 0;
  left: 0;
}

.admin-dashboard .img {
  position: absolute;
  width: 200px;
  height: 200px;
  top: 6px;
  left: 35px;
  object-fit: cover;
}

.admin-dashboard .overlap-3 {
  position: absolute;
  width: 806px;
  height: 1024px;
  top: 0;
  left: 741px;
}

.admin-dashboard .basic-info-group {
  position: absolute;
  width: 776px;
  height: 873px;
  top: 31px;
  left: 30px;
}

.admin-dashboard .rectangle {
  position: absolute;
  width: 416px;
  height: 70px;
  top: 188px;
  left: 0;
  border-radius: 7px;
  border: 2px solid;
  border-color: #e5e5e5;
}

.admin-dashboard .rectangle-2 {
  position: absolute;
  width: 306px;
  height: 70px;
  top: 188px;
  left: 440px;
  border-radius: 7px;
  border: 2px solid;
  border-color: #e5e5e5;
}

.admin-dashboard .rectangle-3 {
  position: absolute;
  width: 746px;
  height: 70px;
  top: 325px;
  left: 0;
  border-radius: 7px;
  border: 2px solid;
  border-color: #e5e5e5;
}

.admin-dashboard .overlap-4 {
  position: absolute;
  width: 746px;
  height: 146px;
  top: 727px;
  left: 0;
  border-radius: 7px;
  border: 2px solid;
  border-color: #e5e5e5;
}

.admin-dashboard .p {
  position: absolute;
  width: 732px;
  top: 3px;
  left: 12px;
  font-family: "Kumbh Sans", Helvetica;
  font-weight: 400;
  color: #6c6c6c;
  font-size: 26px;
  letter-spacing: 0;
  line-height: normal;
}

.admin-dashboard .rectangle-4 {
  position: absolute;
  width: 746px;
  height: 70px;
  top: 462px;
  left: 0;
  border-radius: 7px;
  border: 2px solid;
  border-color: #e5e5e5;
}

.admin-dashboard .text-wrapper-3 {
  position: absolute;
  width: 98px;
  top: 422px;
  left: 0;
  font-family: "Kumbh Sans", Helvetica;
  font-weight: 600;
  color: #000000;
  font-size: 20px;
  letter-spacing: 0;
  line-height: normal;
}

.admin-dashboard .text-wrapper-4 {
  position: absolute;
  width: 84px;
  top: 285px;
  left: 0;
  font-family: "Kumbh Sans", Helvetica;
  font-weight: 600;
  color: #000000;
  font-size: 20px;
  letter-spacing: 0;
  line-height: normal;
}

.admin-dashboard .text-wrapper-5 {
  position: absolute;
  width: 156px;
  top: 148px;
  left: 0;
  font-family: "Kumbh Sans", Helvetica;
  font-weight: 600;
  color: #000000;
  font-size: 20px;
  letter-spacing: 0;
  line-height: normal;
}

.admin-dashboard .text-wrapper-6 {
  position: absolute;
  width: 235px;
  top: 7px;
  left: 0;
  font-family: "Kumbh Sans", Helvetica;
  font-weight: 700;
  color: #000000;
  font-size: 30px;
  letter-spacing: 0;
  line-height: normal;
  white-space: nowrap;
}

.admin-dashboard .text-wrapper-7 {
  position: absolute;
  width: 193px;
  top: 610px;
  left: 0;
  font-family: "Kumbh Sans", Helvetica;
  font-weight: 700;
  color: #000000;
  font-size: 24px;
  letter-spacing: 0;
  line-height: normal;
}

.admin-dashboard .text-wrapper-8 {
  position: absolute;
  width: 129px;
  top: 154px;
  left: 440px;
  font-family: "Kumbh Sans", Helvetica;
  font-weight: 600;
  color: #000000;
  font-size: 20px;
  letter-spacing: 0;
  line-height: normal;
}

.admin-dashboard .overlap-group-2 {
  position: absolute;
  width: 129px;
  height: 59px;
  top: 0;
  left: 417px;
  border-radius: 7px;
}

.admin-dashboard .text-wrapper-9 {
  position: absolute;
  width: 98px;
  top: 17px;
  left: 27px;
  font-family: "Kumbh Sans", Helvetica;
  font-weight: 700;
  color: #6c6c6c;
  font-size: 20px;
  letter-spacing: 0;
  line-height: normal;
}

.admin-dashboard .rectangle-5 {
  position: absolute;
  width: 129px;
  height: 59px;
  top: 0;
  left: 0;
  border-radius: 7px;
  border: 2px solid;
  border-color: #3182ce;
}

.admin-dashboard .overlap-5 {
  position: absolute;
  width: 190px;
  height: 59px;
  top: 0;
  left: 568px;
  background-color: #3182ce;
  border-radius: 7px;
}

.admin-dashboard .text-wrapper-10 {
  position: absolute;
  width: 171px;
  top: 17px;
  left: 18px;
  font-family: "Kumbh Sans", Helvetica;
  font-weight: 700;
  color: #ffffff;
  font-size: 20px;
  letter-spacing: 0;
  line-height: normal;
}

.admin-dashboard .rectangle-6 {
  position: absolute;
  width: 746px;
  height: 3px;
  top: 86px;
  left: 0;
  background-color: #e5e5e5;
}

.admin-dashboard .rectangle-7 {
  position: absolute;
  width: 746px;
  height: 3px;
  top: 666px;
  left: 0;
  background-color: #e5e5e5;
}

.admin-dashboard .rectangle-8 {
  position: absolute;
  width: 1024px;
  height: 2px;
  top: 511px;
  left: -511px;
  background-color: #e6e6e6;
  transform: rotate(90deg);
}

.admin-dashboard .text-wrapper-11 {
  position: absolute;
  width: 132px;
  top: 119px;
  left: 336px;
  font-family: "Kumbh Sans", Helvetica;
  font-weight: 600;
  color: #746f6f;
  font-size: 30px;
  letter-spacing: 0;
  line-height: normal;
}

.admin-dashboard .text-wrapper-12 {
  position: absolute;
  top: 416px;
  left: 255px;
  font-family: "Kumbh Sans", Helvetica;
  font-weight: 500;
  color: #000000;
  font-size: 40px;
  letter-spacing: 0;
  line-height: normal;
}

.admin-dashboard .text-wrapper-13 {
  position: absolute;
  width: 291px;
  top: 467px;
  left: 261px;
  font-family: "Kumbh Sans", Helvetica;
  font-weight: 400;
  color: #6c6c6c;
  font-size: 28px;
  letter-spacing: 0;
  line-height: normal;
}

.admin-dashboard .text-wrapper-14 {
  position: absolute;
  width: 433px;
  top: 644px;
  left: 185px;
  font-family: "Kumbh Sans", Helvetica;
  font-weight: 500;
  color: #6c6c6c;
  font-size: 24px;
  text-align: center;
  letter-spacing: 0;
  line-height: normal;
}

.admin-dashboard .button-follow {
  position: absolute;
  width: 296px;
  height: 65px;
  top: 538px;
  left: 255px;
}

.admin-dashboard .fileprof {
  position:absolute;
  top: 15px;
  left: 15px;
  font-size: 20px;
  outline: none;
  font-weight: bold;
}

.admin-dashboard .overlap-6 {
  position: relative;
  width: 294px;
  height: 65px;
  background-color: #3182ce;
  border-radius: 10px;
}

.admin-dashboard .text-wrapper-15 {
  position: absolute;
  width: 255px;
  top: 14px;
  left: 28px;
  font-family: "Kumbh Sans", Helvetica;
  font-weight: 500;
  color: #ffffff;
  font-size: 28px;
  letter-spacing: 0;
  line-height: normal;
}

.admin-dashboard .sidebar-m-enu {
  position: absolute;
  width: 320px;
  height: 1208px;
  top: 1px;
  left: 1px;
  background-color: #ffffff;
  border-top-right-radius: 10px;
  border-bottom-right-radius: 10px;
  box-shadow: 0px 5px 14px #0000001a;
}

.admin-dashboard .overlap-7 {
  position: relative;
  width: 338px;
  height: 1228px;
  top: -1px;
  left: -4px;
}

.admin-dashboard .sidebar-dashboard {
  position: absolute;
  width: 335px;
  height: 1228px;
  top: 0;
  left: 3px;
}

.admin-dashboard .frame-4 {
  display: inline-flex;
  flex-direction: column;
  align-items: center;
  gap: 34px;
  padding: 0px 47px;
  position: absolute;
  top: 175px;
  left: 0;
}

.admin-dashboard .frame-wrapper {
  position: relative;
  width: 230px;
  height: 59px;
  background-color: #ffffff;
  border-radius: 10px;
}

.admin-dashboard .frame-5 {
  height: 17px;
  gap: 8px;
  padding: 8px 0px 0px;
  position: relative;
  top: 17px;
  left: 7px;
  display: inline-flex;
  align-items: center;
}

.admin-dashboard .vuesax-broken-home {
  position: relative;
  width: 35px;
  height: 30.33px;
  margin-top: -10.67px;
  margin-bottom: -10.67px;
}

.admin-dashboard .text-wrapper-16 {
  position: relative;
  width: fit-content;
  margin-top: -14px;
  margin-bottom: -12px;
  font-family: "Kumbh Sans", Helvetica;
  font-weight: 800;
  color: #746f6f;
  font-size: 28px;
  letter-spacing: 0;
  line-height: normal;
}

.admin-dashboard .frame-6 {
  display: inline-flex;
  height: 17px;
  align-items: center;
  gap: 8px;
  padding: 8px 0px 0px;
  position: relative;
  top: 15px;
  left: 13px;
}

.admin-dashboard .img-2 {
  position: relative;
  width: 28px;
  height: 28px;
  margin-top: -9.5px;
  margin-bottom: -9.5px;
}

.admin-dashboard .text-wrapper-17 {
  position: relative;
  width: fit-content;
  margin-top: -12.5px;
  margin-bottom: -10.5px;
  font-family: "Kumbh Sans", Helvetica;
  font-weight: 800;
  color: #746f6f;
  font-size: 26px;
  letter-spacing: 0;
  line-height: normal;
}

.admin-dashboard .frame-7 {
  position: relative;
  width: 230px;
  height: 59px;
  background-color: #3182ce;
  border-radius: 10px;
}

.admin-dashboard .frame-8 {
  height: 17px;
  gap: 8px;
  padding: 8px 0px 0px 0.5px;
  position: relative;
  top: 15px;
  left: 13px;
  display: inline-flex;
  align-items: center;
}

.admin-dashboard .text-wrapper-18 {
  position: relative;
  width: fit-content;
  margin-top: -12.5px;
  margin-bottom: -10.5px;
  font-family: "Kumbh Sans", Helvetica;
  font-weight: 800;
  color: #ffffff;
  font-size: 26px;
  letter-spacing: 0;
  line-height: normal;
}

.admin-dashboard .logo {
  position: absolute;
  width: 97px;
  height: 97px;
  top: 18px;
  left: 109px;
  background-image: url(/public/Assets/img/img-settings/logo-1.svg);
  background-size: 100% 100%;
}

.admin-dashboard .frame-9 {
  height: 43px;
  gap: 16px;
  padding: 0px 25px;
  position: absolute;
  top: 114px;
  left: 42px;
  display: inline-flex;
  align-items: center;
}

.admin-dashboard .text-wrapper-19 {
  position: relative;
  width: fit-content;
  font-family: "Kumbh Sans", Helvetica;
  font-weight: 600;
  color: #000000;
  font-size: 23px;
  letter-spacing: 0;
  line-height: normal;
}

.admin-dashboard .line {
  position: absolute;
  width: 320px;
  height: 1px;
  top: 156px;
  left: 4px;
  object-fit: cover;
}

.admin-dashboard .rectangle-9 {
  position: absolute;
  width: 107px;
  height: 29px;
  top: -12603px;
  left: -12502px;
}

</style>