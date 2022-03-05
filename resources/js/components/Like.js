import axios from "axios";
import React, { useEffect, useState } from "react";
// import ReactDOM from "react-dom";

function Like(props) {
  const [hasLiked, setHasLiked] = useState(false);
  const [likeCount, setLikeCount] = useState(0);
  const { liked, postId, likeCount: dataLikeCount } = props || {};

  useEffect(() => {
    const parsedLiked = JSON.parse(liked);
    setLikeCount(dataLikeCount);
    setHasLiked(parsedLiked);
  }, []);

  useEffect(() => {
    const parsedLiked = JSON.parse(liked);
    setHasLiked(parsedLiked);
  }, []);

  const likePost = () => {
    console.log(postId);
    axios.post(`/p/like/${postId}`).then((response) => {
      console.log(response.data);
      if (response.data.attached.length > 0) {
        setLikeCount(likeCount + 1);
      } else if (response.data.detached.length > 0) {
        setLikeCount(likeCount - 1);
      }
      console.log(hasLiked);
      setHasLiked(!hasLiked);
    });
  };

  return (
    <div className="d-flex">
      <div className="d-flex align-items-center px-2 border border-secondary bg-dark rounded-start">{likeCount}</div>
      <button
        className={`btn btn${hasLiked ? "" : "-outline"}-secondary custom-btn-radius`}
        onClick={likePost}
      >
        {hasLiked ? "unlike" : "like"}
      </button>
    </div>
  );
}

export default Like;
