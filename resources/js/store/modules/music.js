import axios from 'axios'
import * as types from "../mutation-types";

export const state = {
  musicList: [],
  userPlaylists: []
};

export const getters = {
  getMusicList: state => state.musicList,
  getUserPlaylists: state => state.userPlaylists
};

export const actions = {
  async fetchUserPlayLists({commit}) {
    try {
      const response = await axios.get("/api/playlists");
      commit("SET_USER_PLAY_LISTS", response.data.music);
    } catch (error) {
      console.log(error);
    }
  },
  async fetchMusic({commit}) {
    try {
      const response = await axios.get("/api/music");
      commit("SET_MUSIC_LIST", response.data.music);
    } catch (error) {
      console.log(error);
    }
  }
};

export const mutations = {
  [types.SET_MUSIC_LIST]: (state, musicList) => (state.musicList = musicList),
  [types.SET_USER_PLAY_LISTS]: (state, userPlaylists) => (state.userPlaylists = userPlaylists)
};
