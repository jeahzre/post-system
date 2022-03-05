import axios from "axios";
import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom";

function FollowButton() {
    const [hasFollowed, setHasFollowed] = useState(false);

    useEffect(() => {
        const elementParent = document.getElementById("follow-button");
        const { followed } = elementParent.dataset || {};
        console.log(JSON.parse(followed), 'hasfollowed');
        const parsedFollowed = JSON.parse(followed);
        setHasFollowed(parsedFollowed);
    }, []);

    const followUser = () => {
        const elementParent = document.getElementById("follow-button");
        const { userId } = elementParent.dataset || {};
        console.log(userId);
        axios.post(`/follow/${userId}`).then((response) => {
            console.log(response.data);
            setHasFollowed(!hasFollowed);
        });
    };

    return (
        <button onClick={followUser}>
            {hasFollowed ? "Unfollow" : "Follow"}
        </button>
    );
}

export default FollowButton;

if (document.getElementById("follow-button")) {
    ReactDOM.render(<FollowButton />, document.getElementById("follow-button"));
}
