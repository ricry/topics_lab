<template>
  <div>
    <Card>
      <template #title>
        {{topic.title}}
      </template>
      <template #content>
        <div class="body-text">
          {{topic.body}}
        </div>
      </template>
      <template #footer>
        <div class="like-btn">
          <span class="like-btn__text">{{ topic.likes_count }}</span>
          <Button
            icon="pi pi-heart"
            class="like-icon p-button-rounded p-button-help"
            v-bind:class="classColorSet"
            @click="toggle"
          />
        </div>
        <span>
          <router-link :to="`/user/${user.id}`">{{user.name}}</router-link>
        </span>
      </template>
    </Card>
    <Comments :comments="this.comments" />
    <CommentForm :topicId="this.topic.id" @sentComment="receiveComment" />
  </div>
</template>

<script>
import axios from '@/supports/axios'
import Comments from '@/components/Comments'
import CommentForm from '@/components/CommentForm'

export default {
  name: 'Topic',
  components: {
    Comments,
    CommentForm
  },
  data () {
    return {
      topic: {},
      user: {},
      comments: [],
      id: null,
      isActive: false
    }
  },
  mounted () {
    this.id = this.$route.params.id
    if (!this.id) {
      alert('不正なIDです。')
      this.$router.push('/login')
      return
    }
    if (localStorage.getItem('authenticated') !== 'true') {
      alert('ログインしてください。')
      this.$router.push('/login')
      return
    }
    this.getTopic()
  },
  computed: {
    classColorSet: function () {
      return {
        before: !this.isActive,
        after: this.isActive
      }
    }
  },
  methods: {
    getTopic () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.get(`/api/topic/${this.id}`)
            .then((res) => {
              if (res.status === 200) {
                this.topic = res.data
                this.user = this.topic.user
                this.comments.splice(0)
                this.comments.push(...this.topic.comments)
              } else {
                console.log('取得失敗')
              }
            })
            .catch((err) => {
              console.log(err)
            })
        })
        .catch((err) => {
          alert(err)
        })
    },
    receiveComment (comment) {
      this.comments.push(comment)
    },
    toggle () {
      if (!this.isActive) {
        axios.get('/sanctum/csrf-cookie')
          .then(() => {
            axios.post('/api/topicLike/create', {
              topic_id: this.id
            })
              .then((res) => {
                console.log(res)
              })
              .catch((err) => {
                console.log(err)
              })
          })
      } else {
        axios.get('/sanctum/csrf-cookie')
          .then(() => {
            axios.post('/api/topicLike/destroy', {
              topic_id: this.id
            })
              .then((res) => {
                console.log(res)
              })
              .catch((err) => {
                console.log(err)
              })
          })
      }
      this.isActive = !this.isActive
    }
  }
}

</script>

<style scoped>
.body-text {
  white-space:pre-wrap;
}
.p-card-footer span {
  text-align: right;
  display: block;
}
.before {
  background-color: lightgray;
  border: none;
}
.after {
  background-color: #c94297;
}
</style>
