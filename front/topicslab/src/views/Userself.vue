<template>
  <div>
    <Card>
      <template #title>
        マイページ
      </template>
      <template #content>
        <div v-if="!user.name">
          <Card>
            <template #content>
              <Skeleton width="15%" height="20px"></Skeleton>
              <TabView :topics="this.topics" :comments="this.comments" />
            </template>
          </Card>
        </div>
        <div v-else>
          <Card>
            <template #content>
              {{user.name}}
              <div v-if="this.loaded==false">
                <TabView :topics="this.topics" :comments="this.comments" :loaded="false" />
              </div>
              <div v-else>
                <TabView :topics="this.topics" :comments="this.comments" :loaded="true" />
              </div>
            </template>
          </Card>
        </div>
      </template>
      <template #footer>
        <Button label="トピックを作成" v-on:click="toNewTopic" />
        <Button label="ログアウト" class="p-button-warning" v-on:click="logout" />
        <Button label="退会する" class="p-button-danger" v-on:click="withdraw" />
      </template>
    </Card>
  </div>
</template>

<script>
import axios from '@/supports/axios'
import TabView from '@/components/TabView2'
export default {
  name: 'Userself',
  components: {
    TabView
  },
  data () {
    return {
      user: {},
      topics: [],
      comments: [],
      loaded: false
    }
  },
  mounted () {
    if (localStorage.getItem('authenticated') !== 'true') {
      this.$router.push('/login')
      return
    }
    this.getUser()
  },
  methods: {
    toNewTopic () {
      this.$router.push('/topic')
    },
    logout () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.post('/api/logout')
            .then(res => {
              console.log(res)
              localStorage.setItem('authenticated', 'false')
              this.$router.push('/login')
            })
            .catch(err => {
              console.log(err)
            })
        })
        .catch((err) => {
          alert(err)
        })
    },
    withdraw () {
      //
    },
    getUser () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.get('/api/user')
            .then((res) => {
              if (res.status === 200) {
                this.user = res.data
                this.topics.splice(0)
                this.topics.push(...this.user.topics)
                this.loaded = true
                this.comments.splice(0)
                this.comments.push(...this.user.comments)
              } else {
                console.log('取得失敗')
              }
            })
        })
        .catch((err) => {
          alert(err)
        })
    }
  }
}
</script>

<style lang="scss" scoped>
.p-card-footer {
  .p-button {
    margin-right: 10px;
  }
}
</style>
