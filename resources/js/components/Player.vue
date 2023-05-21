<template>
  <div v-show="audioSrc" class="player-wrapper">
    <div class="player-scale">
      <input v-model="audioTime" type="range" min="0" :max="Math.round(audioDuration)" @input.stop="seekAudio()">
    </div>
    <audio ref="audio" :src="audioSrc?`/storage/${audioSrc}`:''" @timeupdate="updateTime"/>
    <div class="player-buttons">
      <div class="player-control-back" @click="prevTrack()">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="30" viewBox="0 0 14 13"
             fill="none"
        >
          <g opacity="0.6">
            <path d="M2.15179 6.5L12.8483 12.675L12.8483 0.324999L2.15179 6.5Z" fill="white"/>
            <rect x="2" y="12" width="2" height="11" transform="rotate(180 2 12)" fill="white"/>
          </g>
        </svg>
      </div>
      <div v-if="!play" class="player-play" @click="playAudio()">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="30"
             viewBox="0 0 23 30" fill="none"
        >
          <g>
            <path d="M23 15L0 0V30L23 15Z" fill="white"/>
          </g>
        </svg>
      </div>
      <div v-if="play" class="player-play" @click="pauseAudio()">
        <svg id="Capa_1" xmlns="http://www.w3.org/2000/svg"
             xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"
             version="1.1" width="14" height="30" viewBox="0 0 332.145 332.146" xml:space="preserve"
        ><g><g>
          <path
            d="M121.114,0H25.558c-8.017,0-14.517,6.5-14.517,14.515v303.114c0,8.017,6.5,14.517,14.517,14.517h95.556    c8.017,0,14.517-6.5,14.517-14.517V14.515C135.631,6.499,129.131,0,121.114,0z M106.6,303.113H40.072V29.031H106.6V303.113z"
          />
          <path
            d="M306.586,0h-95.541c-8.018,0-14.518,6.5-14.518,14.515v303.114c0,8.017,6.5,14.517,14.518,14.517h95.541    c8.016,0,14.518-6.5,14.518-14.517V14.515C321.102,6.499,314.602,0,306.586,0z M292.073,303.113h-66.514V29.031h66.514V303.113z"
          />
        </g>
        </g>
        </svg>
      </div>
      <div class="player-control-next" @click="nextTrack()">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="30" viewBox="0 0 14 13"
             fill="none"
        >
          <g opacity="0.6">
            <path d="M11.8482 6.5L1.15173 0.325001V12.675L11.8482 6.5Z" fill="white"/>
            <rect x="12" y="1" width="2" height="11" fill="white"/>
          </g>
        </svg>
      </div>
      <div v-if="isRepeat" @click="repeatAudio()">
        <svg fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
          <g fill="white">
            <path clip-rule="evenodd"
                  d="M12.48 9.13a.9.9 0 0 1 .42.77v4.2a.9.9 0 0 1-1.8 0v-2.74a.9.9 0 0 1-.8-1.6l1.3-.67a.9.9 0 0 1 .88.04z"
                  fill-rule="evenodd"
            />
            <path
              d="M2 12a5.9 5.9 0 0 1 5.9-5.9h10.03l-.56-.56a.9.9 0 1 1 1.27-1.28l2.1 2.1a.9.9 0 0 1 0 1.28l-2.1 2.1a.9.9 0 0 1-1.27-1.28l.56-.56H7.91A4.1 4.1 0 0 0 3.8 12v.1a.9.9 0 0 1-1.8 0zm19.1-1c.5 0 .9.4.9.9v.1a5.9 5.9 0 0 1-5.9 5.9H6.07l.57.56a.9.9 0 1 1-1.28 1.28l-2.1-2.1a.9.9 0 0 1 0-1.28l2.1-2.1a.9.9 0 0 1 1.28 1.28l-.57.56H16.1a4.1 4.1 0 0 0 4.1-4.1v-.1c0-.5.4-.9.9-.9z"
            />
          </g>
        </svg>
      </div>
      <div v-if="!isRepeat" @click="repeatAudio()">
        <svg fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
          <g fill="white">
            <path
              d="M2 12a5.9 5.9 0 0 1 5.9-5.9h10.03l-.56-.56a.9.9 0 1 1 1.27-1.28l2.1 2.1a.9.9 0 0 1 0 1.28l-2.1 2.1a.9.9 0 0 1-1.27-1.28l.56-.56H7.91A4.1 4.1 0 0 0 3.8 12v.1a.9.9 0 0 1-1.8 0zm19.1-1c.5 0 .9.4.9.9v.1a5.9 5.9 0 0 1-5.9 5.9H6.07l.57.56a.9.9 0 1 1-1.28 1.28l-2.1-2.1a.9.9 0 0 1 0-1.28l2.1-2.1a.9.9 0 0 1 1.28 1.28l-.57.56H16.1a4.1 4.1 0 0 0 4.1-4.1v-.1c0-.5.4-.9.9-.9z"
            />
          </g>
        </svg>
      </div>
      <div class="player-album">
        <img v-show="currentTrack.logo_url" class="music-logo_url" :src="`${currentTrack.logo_url}`">
      </div>
      <div class="player-track-info">
        <span>{{ currentTrack.title }}</span>
        <span>{{ currentTrack.artist }}</span>
      </div>
      <div class="time-line">
        <span>{{ currentTime }} / {{ duration }}</span>
      </div>
      <div class="volume">
        <input v-model="volume" type="range" min="0" max="100" @input="setVolume">
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import musicListItem from './MusicListItem'

export default {
  name: 'VPlayer',

  data () {
    return {
      firstPlayed: false,
      play: false,
      isRepeat: false,
      audioSrc: '',
      currentTrack: {},
      audioTime: 0,
      audioDuration: 0,
      currentTime: '0:00',
      volume: 100
    }
  },
  watch: {
    'musicList' () {
      this.onChangePlaylist(false)
    },
    'currentTrackId' () {
      this.onChangePlaylist(true)
    },
    'audioTime' () {
      this.updateTime()
    },
    'play' () {
      if (!this.play) {
        this.$refs.audio.pause()
      } else {
        this.$refs.audio.play()
        this.$refs.audio.oncanplaythrough = () => {
          this.$refs.audio.play()
        }
      }
    },
    'currentTime' () {
      if (!this.isRepeat) {
        if (this.currentTime >= this.duration) {
          this.nextTrack()
        }
      }
    }
  },
  methods: {
    onChangePlaylist (play) {
      if (!play) {
        this.$refs.audio.volume = this.volume / 100
        this.audioSrc = this.musicList[0].path
        this.audioDuration = this.musicList[0].seconds
        this.currentTrack = this.musicList[0]
        this.setMediaSession(this.musicList[0])
        this.pauseAudio()
      } else {
        this.changeTrack(this.musicList.find(item => item.id === this.currentTrackId))
      }
    },
    setMediaSession (track) {
      if ('mediaSession' in navigator) {
        navigator.mediaSession.setActionHandler('play', this.playAudio)
        navigator.mediaSession.setActionHandler('pause', this.pauseAudio)
        navigator.mediaSession.setActionHandler('previoustrack', this.prevTrack)
        navigator.mediaSession.setActionHandler('nexttrack', this.nextTrack)
        navigator.mediaSession.metadata = new MediaMetadata({
          title: track.title,
          artist: track.artist,
          artwork: [
            {
              sizes: '160x160',
              src: `${track.logo_url}`,
              type: ''
            }
          ]
        })
      }
    },
    repeatAudio () {
      this.isRepeat = !this.isRepeat
      this.$refs.audio.loop = this.isRepeat
    },
    setVolume () {
      this.$refs.audio.volume = this.volume / 100
    },
    nextTrack () {
      this.pauseAudio()
      this.audioTime = 0
      this.audioDuration = 0
      this.currentTime = 0
      const currentIndex = this.musicList.findIndex(track => track.path === this.audioSrc)
      let nextIndex = currentIndex + 1
      if (nextIndex >= this.musicList.length) {
        nextIndex = 0
      }
      this.changeTrack(this.musicList[nextIndex])
    },
    prevTrack () {
      if (this.audioTime > 5) {
        this.audioTime = 0
        this.seekAudio()
        return
      }
      const currentIndex = this.musicList.findIndex(track => track.path === this.audioSrc)
      let prevIndex = currentIndex - 1
      if (prevIndex < 0) {
        prevIndex = this.musicList.length - 1
      }
      this.changeTrack(this.musicList[prevIndex])
    },
    playAudio () {
      this.firstPlayed = true
      this.play = true
      this.$refs.audio.currentTime = this.audioTime
      this.$refs.audio.play()
      this.$refs.audio.oncanplaythrough = () => {
        this.$refs.audio.play()
      }
    },
    pauseAudio () {
      this.play = false
      this.$refs.audio.pause()
    },
    updateTime () {
      this.audioTime = this.$refs.audio.currentTime
      this.currentTime = this.formatTime(this.audioTime)
    },
    seekAudio () {
      this.currentTime = this.formatTime(this.audioTime)
      if (this.play) {
        this.$refs.audio.currentTime = this.audioTime
      }
    },
    changeTrack (track) {
      this.pauseAudio()
      this.audioTime = 0
      this.audioDuration = 0
      this.currentTime = 0
      this.currentTrack = track
      this.audioSrc = track.path
      this.audioDuration = track.seconds
      this.playAudio()
      this.setMediaSession(track)
    },
    formatTime (time) {
      const minutes = Math.floor(time / 60)
      let seconds = Math.floor(time % 60)
      if (seconds < 10) {
        seconds = `0${seconds}`
      }
      return `${minutes}:${seconds}`
    }
  },
  computed: {
    ...mapGetters({
      authenticated: 'auth/check'
    }),
    ...mapState({
      musicList: state => state.music.currentPlaylist,
      currentTrackId: state => state.music.currentActiveTrack
    }),
    duration () {
      return this.formatTime(this.audioDuration)
    }
  }
}
</script>
