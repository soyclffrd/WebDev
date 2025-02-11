<!-- StatisticsCard.vue -->
<template>
    <div class="stat-card" :style="{ borderColor: color }">
      <div class="stat-icon" :style="{ backgroundColor: color }">
        <img :src="icon" :alt="title" />
      </div>
      <div class="stat-content">
        <h3>{{ title }}</h3>
        <p class="stat-count">{{ count }}</p>
        <Link :href="link" class="stat-link">View Details →</Link>
      </div>
    </div>
  </template>
  
  <script setup>
  import { defineProps } from 'vue';
  import { Link } from '@inertiajs/vue3';
  
  const props = defineProps({
    title: String,
    count: Number,
    icon: String,
    link: String,
    color: String,
  });
  </script>
  
  <style scoped>
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
  </style>
  