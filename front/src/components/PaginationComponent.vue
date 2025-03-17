<template>
  <div class="mt-4">
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
        <li 
          v-for="(link, index) in paginationLinks" 
          :key="index"
          class="page-item"
          :class="{ 
            'active': link.active,
            'disabled': !link.url
          }"
        >
          <button
            class="page-link"
            @click="changePage(link.label)"
            v-html="link.label"
          ></button>
        </li>
      </ul>
    </nav>
  </div>
</template>