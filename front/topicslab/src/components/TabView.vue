<template>
  <div id="tab">
    <ul class="tabMenu">
      <li
        v-on:click="isSelect('1')"
        v-bind:class="{'active': isActive === '1'}">トピック</li>
      <li
        v-on:click="isSelect('2')"
        v-bind:class="{'active': isActive === '2'}">コメント</li>
    </ul>
    <div class="tabContents">
      <div v-if="isActive === '1'">
        <Card>
          <template #title>
            {{topic.title}}
          </template>
          <template #content>
            <div class="body-text">
              {{topic.body}}
            </div>
          </template>
        </Card>
      </div>
      <div v-else-if="isActive === '2'">
        <Comments :comments="this.comments" />
      </div>
    </div>
  </div>
</template>

<script>
import axios from '@/supports/axios'
import Comments from '@/components/Comments'
export default {
  components: {
    Comments
  },
  el: '#tab',
  data () {
    return {
      isActive: '1',
      user: {},
      topic: {},
      comments: [],
      id: null
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
    isSelect: function (num) {
      this.isActive = num
    }
  }
}
</script>

<style lang="scss" scoped>
#tab {
  width: 100%;
  max-width: 500px;
  margin: 40px auto;
  .tabMenu {
    display: flex;
    margin: 0 auto;
    li {
      width: none;
      list-style: none;
      padding: 10px 20px;
      border-right: 1px solid white;
      cursor: pointer;
      background-color: lightgray;
      color: #bc5f6a;
      &:last-child {
        border-right: none;
      }
    }
    li.active {
      background-color: #bc5f6a;
      color: white;
    }
  }
  .tabContents {
    width: 100%;
    padding: 20px;
    border: 1px solid #bc5f6a;
    h2 {
      margin: 0 0 10px 0;
      font-size: 20px;
      font-weight: bolder;
    }
  }
}
.body-text {
  white-space:pre-wrap;
}
.p-card-footer span {
  text-align: right;
  display: block;
}
</style>
