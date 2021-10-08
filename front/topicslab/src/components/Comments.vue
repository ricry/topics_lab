<template>
  <div>
    <Fieldset v-for="comment in comments" :key="comment.id">
      <template #legend>
        <span>
          <router-link :to="`/user/${comment.user.id}`">{{comment.user.name}}</router-link>
        </span>
      </template>
      <div class="comment-wrap">
        <div class="comment-text">
          {{comment.body}}
        </div>
        <div class="like-btn">
          <span class="commentlike-text">{{ comment.likes_count }}</span>
          <Button
            icon="pi pi-heart"
            class="comment-like p-button-rounded p-button-help"
            v-on:click="isActive = !isActive"
            v-bind:class="classColorSet"
          />
        </div>
      </div>
    </Fieldset>
  </div>
</template>

<script>
export default {
  name: 'Comments',
  props: {
    comments: Array
  },
  data () {
    return {
      isActive: false
    }
  },
  computed: {
    classColorSet: function () {
      return {
        'comment-like--active': this.isActive,
        'comment-like--inactive': !this.isActive
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.p-fieldset {
  margin-top: 20px;
}

.comment-text {
  white-space:pre-wrap;
}
.comment-like--inactive {
  background-color: lightgray;
  border: none;
}
.comment-like--active {
  background-color: #c94297;
}
.comment-wrap {
  display: flex;
}
</style>
