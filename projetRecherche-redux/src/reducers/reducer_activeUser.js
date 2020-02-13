import { USER_SELECTED } from '../actions/index';

export default function(state = null, action) {
    switch (action.type) {
        case USER_SELECTED:
            return action.payload;
            break;

        default:
            break;
    }
    return state;
}
