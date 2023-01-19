import axios from 'axios'
import * as types from "../mutation-types";

export const state = {
  musicList: []
};

export const getters = {
  getMusicList: state => state.musicList
};

export const actions = {
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
  [types.SET_MUSIC_LIST]: (state, musicList) => (state.musicList = musicList)
};
