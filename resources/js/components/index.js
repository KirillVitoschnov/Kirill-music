import Vue from 'vue'
import Card from './Card.vue'
import Child from './Child.vue'
import Button from './Button.vue'
import Checkbox from './Checkbox.vue'
import Player from './player'
import Sidebar from './Sidebar'
import Content from './Content'
import NavbarContent from './NavbarContent'
import { HasError, AlertError, AlertSuccess } from 'vform/components/bootstrap5'
import MusicListItem from './MusicListItem'
import PlaylistCard from './playlistCard';

[
  Content,
  Sidebar,
  Player,
  Card,
  Child,
  Button,
  Checkbox,
  HasError,
  AlertError,
  AlertSuccess,
  NavbarContent,
  MusicListItem,
  PlaylistCard
].forEach(Component => {
  Vue.component(Component.name, Component)
})
