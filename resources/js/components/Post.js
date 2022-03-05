import axios from "axios";
import React, { useEffect, useState } from "react";
import ReactDOMServer from "react-dom/server";
import ReactDOM from "react-dom";
import Comment from "./Comment";
import CommentButton from "./CommentButton";
import Like from "./Like";

function Post({ dataset }) {
  const [showMoreFeature, setShowMoreFeature] = useState(false);
  const [parsedDataset, setParsedDataset] = useState({});
  const [commented, setCommented] = useState(false);
  const [commentCount, setCommentCount] = useState(0);

  const {
    postId,
    post,
    postUserProfileImage,
    likeCount,
    liked,
    user,
    isShowOne,
    canDelete
  } = parsedDataset || {};

  useEffect(() => {
    // console.log(dataset);
    const parsedDataset = {};
    // parse dataset from JSON string to JS Object
    console.log(dataset);
    Object.entries(dataset).map(([key, value]) => {
      console.log(value);
      parsedDataset[key] = JSON.parse(value);
    });
    setParsedDataset(parsedDataset);

    const { commentCount, commented } = parsedDataset;
    setCommented(commented);
    setCommentCount(commentCount);
    console.log(parsedDataset);
  }, []);

  const handleToggleMoreFeature = () => {
    setShowMoreFeature(!showMoreFeature);
  };

  const handleCloseMoreFeature = () => {
    setShowMoreFeature(false);
  };

  const submitCommentPost = (e) => {
    e.preventDefault();
    const commentTextAreaElement = e.currentTarget.previousSibling;
    const comment = commentTextAreaElement.value;
    const token = document.head.querySelector('meta[name="csrf-token"]');

    const data = {
      comment,
    };
    const config = {
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN'": token,
      },
    };

    axios.post(`/comment/${postId}`, data, config).then((response) => {
      // setHasCommented(!hasCommented);
      if (response.data) {
        const { user, user_comment } = response.data;
        const commentProps = {
          user,
          user_comment,
        };
        const postElement = e.target.closest(".post");
        const postId = postElement.dataset.postId;
        const commentsElement = document.getElementById(`comments-${postId}`);
        const commentElementString = ReactDOMServer.renderToString(
          <Comment {...commentProps} />
        );
        const commentElement = document.createElement("div");
        commentElement.innerHTML = commentElementString;
        commentsElement.appendChild(commentElement);
        commentTextAreaElement.value = "";

        if (commented === false) {
          setCommented(true);
        }
        setCommentCount(commentCount + 1);
      }
    });
  };

  const toggleMenu = () => {
    const postMenuElement = document.getElementById(`post-menu-${postId}`);
    postMenuElement.classList.toggle("show");
  };

  const renderPostMenu = () => {
    console.log('CAN DELETE', canDelete, user);
    return (
      <div id={`post-menu-${postId}`} className="position-absolute top-100 end-0 p-2">
        <ul className="list-group">
          <li className="list-group-item">
            {canDelete && (
              <button className="btn btn-secondary" onClick={deletePost}>
                Delete
              </button>
            )}
          </li>
        </ul>
      </div>
    );
  };

  const renderPostHeader = () => {
    const {
      user_id,
      user: { username },
    } = post;

    return (
      <div className="d-flex align-items-center bg-dark p-1">
        <div className="d-flex align-items-center">
          <a
            href={`/profile/${user_id}`}
            className="col-2 me-3 d-flex justify-content-center"
          >
            <img
              className="w-50 rounded-circle p-2"
              src={postUserProfileImage}
              alt="profile picture"
            />
          </a>
          <a href={`/profile/${user_id}`} className="text-decoration-none">
            <strong className="fs-6">{username}</strong>
          </a>
        </div>
        <div className="position-relative">
          {canDelete && <button className="btn btn-outline-secondary" onClick={toggleMenu}>
            :
          </button>}
          {renderPostMenu()}
        </div>
      </div>
    );
  };

  const renderImage = () => {
    const { id, image } = post;
    if (!isShowOne) {
      return (
        <a href={`/p/${id}`} className="row w-100 m-0">
          <img className="w-100 p-0" src={`/storage/${image}`} alt="image" />
        </a>
      );
    } else {
      return (
        <div className="row w-100 m-0">
          <img className="w-100 p-0" src={`/storage/${image}`} alt="image" />
        </div>
      );
    }
  };

  const renderPostInfo = () => {
    const {
      user: { username },
      caption,
      created_at,
      user_id,
    } = post;

    return (
      <div className="bg-dark p-1 ps-3">
        <div className="d-flex gap-4">
          {user && <Like {...likeProps} />}
          <CommentButton {...commentButtonProps} />
        </div>
        <a className="text-decoration-none" href={`/profile/${user_id}`}>
          <strong>{username}</strong>
        </a>
        <p>{caption}</p>
        <time>{created_at}</time>
      </div>
    );
  };

  const renderCloseBtn = () => {
    return (
      <button
        type="button"
        className="position-absolute top-0 end-0 btn btn-dark"
        onClick={handleCloseMoreFeature}
      >
        X
      </button>
    );
  };

  const renderComments = () => {
    const { commenters } = post;
    return (
      <div className="h-100" id={`comments-${postId}`}>
        {commenters.map((commenter) => {
          const { pivot, ...user } = commenter;
          const commentProps = {
            user,
            user_comment: pivot,
          };
          return <Comment {...commentProps} key={pivot.id} />;
        })}
      </div>
    );
  };

  const renderAction = () => {
    return (
      <div>
        <div>
          <button type="button" className="btn btn-dark">
            :)
          </button>
          <label htmlFor={`comment-${postId}`} className="btn btn-dark">
            comment
          </label>
        </div>
        <div className={`d-flex`}>
          <textarea
            name="comment"
            id={`comment-${postId}`}
            cols="30"
            rows="10"
            className="form-control"
          ></textarea>
          <button
            type="button"
            className="btn btn-primary"
            onClick={submitCommentPost}
          >
            Submit
          </button>
        </div>
      </div>
    );
  };

  const deletePost = () => {
    const postElement = document.querySelector(".post");
    const postId = postElement.dataset.postId;
    axios.delete(`/p/${postId}`).then((response) => {
      if (response.data === "deleted") {
        window.location = "/";
      }
    });
  };

  const likeProps = {
    postId,
    likeCount,
    liked,
  };
  const commentButtonProps = {
    commentCount,
    commented,
    handleToggleMoreFeature,
  };

  if (Object.keys(parsedDataset).length > 0) {
    return (
      <>
        <div
          className="d-flex post justify-content-center"
          data-post-id={postId}
        >
          <div className="col-8">
            {renderPostHeader()}
            {renderImage()}
            {renderPostInfo()}
          </div>
          <form
            className={`d-flex flex-column justify-content-between col-4 border border-light hmp-600 more-feature ${
              showMoreFeature ? "show" : ""
            } position-relative`}
          >
            {renderCloseBtn()}
            {renderComments()}
            {user && renderAction()}
          </form>
        </div>
      </>
    );
  } else {
    return null;
  }
}

export default Post;

const parentElements = document.querySelectorAll("[react-component='Post']");
if (parentElements.length > 0) {
  Array.from(parentElements).map((parentElement) => {
    const dataset = parentElement.dataset;
    ReactDOM.render(<Post dataset={dataset} />, parentElement);
  });
}
