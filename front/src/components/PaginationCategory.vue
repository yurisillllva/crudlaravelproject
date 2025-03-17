<template>
  <div class="mt-4" v-if="paginationLinks.length > 0">
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
        <li 
          v-for="(link, index) in paginationLinks" 
          :key="index"
          class="page-item"
          :class="{ 
            'active': link.active,
            'disabled': !link.url || link.active
          }"
        >
          <button
            class="page-link"
            @click="handlePageClick(link.url)"
            v-html="link.label"
            :disabled="!link.url || link.active"
          ></button>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {
  props: {
    paginationLinks: {
      type: Array,
      required: true,
      default: () => []
    }
  },
  methods: {
    handlePageClick(url) {
      if (!url) return;
      const page = new URL(url).searchParams.get('page');
      this.$emit('page-changed', parseInt(page));
    }
  }
}
</script>

<style scoped>
/* .pagination {
  margin: 20px 0;
}

.page-item.active .page-link {
  background-color: #007bff;
  border-color: #007bff;
  color: white;
}

.page-link {
  color: #007bff;
  cursor: pointer;
}

.page-link:disabled {
  cursor: not-allowed;
  opacity: 0.6;
} */
</style>