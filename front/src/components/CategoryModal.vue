<template>
  <div v-if="show" class="modal fade show d-block" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <form @submit.prevent="saveCategory"> 
        <div class="modal-header">
          <h5 class="modal-title">
            {{ category?.id ? 'Editar Categoria' : 'Nova Categoria' }}
          </h5>
          <button type="button" class="btn-close" @click="$emit('close')"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nome</label>
            <input v-model="formData.name" type="text" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea v-model="formData.description" class="form-control"></textarea>
          </div>
          <div class="mb-3" v-if="!isChild">
            <label class="form-label">Categoria Pai</label>
            <select v-model="formData.parent_id" class="form-select">
              <option :value="null">Nenhuma (Categoria Principal)</option>
              <option 
                v-for="parent in parentCategories"
                :key="parent.id"
                :value="parent.id"
              >
                {{ parent.name }}
              </option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="$emit('close')">
            Cancelar
          </button>
           <button type="submit" class="btn btn-primary">
            Salvar
          </button>
        </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    show: Boolean,
    category: {
      type: Object,
      default: () => ({}) 
    },
    parentCategories: Array
  },
  data() {
     return {
      formData: {
        name: this.category?.name || '',
        description: this.category?.description || '',
        parent_id: this.category?.parent_id || null
      }
    }
  },
  watch: {
    category: {
      immediate: true,
      handler(newVal) {
        this.formData = newVal?.id 
          ? { ...newVal } 
          : { name: '', description: '', parent_id: null }
      }
    }
  },
  methods: {
    async saveCategory() {
        try {
            const response = await this.$axios({
            method: this.category?.id ? 'put' : 'post',
            url: this.category?.id ? `/categories/${this.category.id}` : '/categories',
            data: this.formData
            });
            
            if (response.status === 200 || response.status === 201) {
            this.$emit('saved', response.data); // Passar dados salvos
            this.$emit('close');
            }
        } catch (error) {
            // Tratar erros de validação do Laravel
            if (error.response?.status === 422) {
            const errors = error.response.data.errors;
            alert(Object.values(errors).join('\n'));
            } else {
            alert('Erro inesperado: ' + error.message);
            }
        }
    },
  },
}
</script>

<style scoped>
.modal-backdrop {
  background-color: rgba(0, 0, 0, 0.5);
}
</style>