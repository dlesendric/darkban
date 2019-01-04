import { FETCH_BOARDS, ADD_BOARD } from "../actions/types";

const initialState = {
  items: [],
  board: {},
};

export default function (state = initialState, action) {
  switch (action.type) {
    case FETCH_BOARDS:
      return {
        ...state,
        items: action.payload,
      };
    case ADD_BOARD:
      let board = action.payload;
      board.totalLists = 0;
      board.totalTasks = 0;
      return {
        ...state,
        board: board
      };
    default:
      return state;
  }
}