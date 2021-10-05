<template>
  <div>
    <Fieldset v-for="comment in comments" :key="comment.id">
      <template #legend>
        <span>{{comment.user.name}}</span>
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
      isActive: true
    }
  },
  computed: {
    classColorSet: function () {
      return {
        before: this.isActive,
        after: !this.isActive
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
.before {
  background-color: lightgray;
  border: none;
}
.after {
  background-color: #c94297;
}
.comment-wrap {
  display: flex;
}
</style>
