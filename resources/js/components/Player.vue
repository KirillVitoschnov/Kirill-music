<template>
  <div class="player-wrapper">
    <div class="player-scale">
      <input type="range" v-model="audioTime" @input="seekAudio" min="0" :max="Math.round(audioDuration)">
    </div>
    <audio ref="audio" :src="`/storage/${audioSrc}`" @timeupdate="updateTime"></audio>
    <div class="player-buttons">
      <div @click="prevTrack()" class="player-control-back">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="30" viewBox="0 0 14 13"
             fill="none">
          <g opacity="0.6">
            <path d="M2.15179 6.5L12.8483 12.675L12.8483 0.324999L2.15179 6.5Z" fill="white"/>
            <rect x="2" y="12" width="2" height="11" transform="rotate(180 2 12)" fill="white"/>
          </g>
        </svg>
      </div>
      <div @click="playAudio()" v-if="!play" class="player-play">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="30"
             viewBox="0 0 23 30" fill="none">
          <g>
            <path d="M23 15L0 0V30L23 15Z" fill="white"/>
          </g>
        </svg>
      </div>
      <div @click="pauseAudio()" v-if="play" class="player-play">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             fill="#000000" version="1.1"
             id="Capa_1" width="14" height="30" viewBox="0 0 332.145 332.146" xml:space="preserve"><g><g>
		     <path
           d="M121.114,0H25.558c-8.017,0-14.517,6.5-14.517,14.515v303.114c0,8.017,6.5,14.517,14.517,14.517h95.556    c8.017,0,14.517-6.5,14.517-14.517V14.515C135.631,6.499,129.131,0,121.114,0z M106.6,303.113H40.072V29.031H106.6V303.113z"/>
        <path
          d="M306.586,0h-95.541c-8.018,0-14.518,6.5-14.518,14.515v303.114c0,8.017,6.5,14.517,14.518,14.517h95.541    c8.016,0,14.518-6.5,14.518-14.517V14.515C321.102,6.499,314.602,0,306.586,0z M292.073,303.113h-66.514V29.031h66.514V303.113z"/>
	       </g>
        </g>
        </svg>

      </div>
      <div @click="nextTrack()" class="player-control-next">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="30" viewBox="0 0 14 13"
             fill="none">
          <g opacity="0.6">
            <path d="M11.8482 6.5L1.15173 0.325001V12.675L11.8482 6.5Z" fill="white"/>
            <rect x="12" y="1" width="2" height="11" fill="white"/>
          </g>
        </svg>
      </div>
      <button v-if="false" @click="repeatAudio()">Repeat</button>
      <div class="player-album">
        <img class="music-logo_url" :src="`${currentTrack.logo_url}`">
      </div>
      <div class="player-track-info">
        <span>{{ currentTrack.title }}</span>
        <span>{{ currentTrack.artist }}</span>
      </div>
      <div class="time-line">
        <span>{{ currentTime }} / {{ duration }}</span>

      </div>
      <div class="volume">
        <input type="range" v-model="volume" min="0" max="100" @input="setVolume">
      </div>
    </div>

  </div>
</template>

<script>

import {mapGetters} from "vuex";

export default {
  name: 'VPlayer',

  data() {
    return {
      firstPlayed: false,
      play: false,
      isRepeat: false,
      audioSrc: '',
      currentTrack: {},
      audioTime: 0,
      audioDuration: 0,
      currentTime: '0:00',
      volume: 100,
    }
  },
  async mounted() {
    this.$refs.audio.volume = this.volume / 100;
    await this.$store.dispatch('music/fetchMusic')
    this.audioSrc = this.musicList.data[0].path;
    this.audioDuration = this.musicList.data[0].seconds;
    this.currentTrack = this.musicList.data[0]
    if ('mediaSession' in navigator) {
      navigator.mediaSession.setActionHandler('play', this.playAudio);
      navigator.mediaSession.setActionHandler('pause', this.pauseAudio);
      navigator.mediaSession.setActionHandler('previoustrack', this.prevTrack);
      navigator.mediaSession.setActionHandler('nexttrack', this.nextTrack);
      navigator.mediaSession.metadata = new MediaMetadata({
        title: this.musicList.data[0].title,
        artist: this.musicList.data[0].artist,
        artwork: [
          {
            "sizes": "160x160",
            "src": `${this.musicList.data[0].logo_url}`,
            "type": ""
          }
        ]
      });
    }
  },
  watch: {
    'currentTime'() {
      if (this.currentTime == this.duration) {
        this.nextTrack()
      }
    }
  },
  methods: {
    repeatAudio() {
      this.isRepeat = !this.isRepeat;
      this.$refs.audio.loop = this.isRepeat;
    },
    setVolume() {
      this.$refs.audio.volume = this.volume / 100;
    },
    nextTrack() {
      this.pauseAudio()
      this.audioTime = 0
      this.audioDuration = 0
      this.currentTime = 0
      let currentIndex = this.musicList.data.findIndex(track => track.path === this.audioSrc);
      let nextIndex = currentIndex + 1;
      if (nextIndex >= this.musicList.data.length) {
        nextIndex = 0;
      }
      this.changeTrack(this.musicList.data[nextIndex]);
    },
    prevTrack() {
      if (this.audioTime > 5) {
        this.audioTime = 0
        this.seekAudio()
        return
      }
      this.pauseAudio()
      this.audioTime = 0
      this.audioDuration = 0
      this.currentTime = 0
      let currentIndex = this.musicList.data.findIndex(track => track.path === this.audioSrc);
      let prevIndex = currentIndex - 1;
      if (prevIndex < 0) {
        prevIndex = this.musicList.data.length - 1;
      }
      this.changeTrack(this.musicList.data[prevIndex]);
    },
    playAudio() {
      this.firstPlayed = true
      this.play = true
      this.$refs.audio.play();
      this.$refs.audio.oncanplaythrough = () => {
        this.$refs.audio.play();
      };
    },
    pauseAudio() {
      this.play = false
      this.$refs.audio.pause();
    },
    updateTime() {
      this.audioTime = this.$refs.audio.currentTime;
      this.currentTime = this.formatTime(this.audioTime);
    },
    seekAudio() {
      if (this.firstPlayed) {
        this.play = true
      }
      this.$refs.audio.currentTime = this.audioTime;
    },
    changeTrack(track) {
      this.currentTrack = track
      this.audioSrc = track.path;
      this.audioDuration = track.seconds;
      this.playAudio()
      if ('mediaSession' in navigator) {
        navigator.mediaSession.metadata = new MediaMetadata({
          title: track.title,
          artist: track.artist,
          artwork: [
            {
              "sizes": "160x160",
              "src": `${track.logo_url}`,
              "type": ""
            }
          ]
        });
      }


    },
    formatTime(time) {
      let minutes = Math.floor(time / 60);
      let seconds = Math.floor(time % 60);
      if (seconds < 10) {
        seconds = `0${seconds}`;
      }
      return `${minutes}:${seconds}`;
    }
  },
  computed: {
    ...mapGetters({
      musicList: 'music/getMusicList',
      authenticated: 'auth/check'
    }),
    duration() {
      return this.formatTime(this.audioDuration);
    }
  }
}
</script>

