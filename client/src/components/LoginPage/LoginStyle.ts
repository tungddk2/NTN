import { makeStyles } from "@mui/styles";
import bgImg from "../../assets/imgs/bg-01.webp";

export const useStyle = makeStyles({
	root: {
		display: "flex",
		alignItems: "center",
		justifyContent: "center",
		width: "100vw",
		height: "100vh",
		overflow: "hidden",
		backgroundImage: `url(${bgImg})`,
		backgroundSize: "cover",
		backgroundRepeat: "no-repeat",
		backgroundPosition: "center",
	}, 
	loginBox: {
		display: "flex",
		flexDirection: "column",
		maxWidth: "50rem",
		width: "30rem",
		backgroundColor: "white",
		borderRadius: "15px",
		padding: "2rem",
	},
	loginBtn: {
		borderRadius: "15px !important",
		transform: "translate3d(0, 0, 0)",
		transition: "all .3s !important",
		"&:hover": {
			transform: "scale(1.05)",
			transitionDuration: ".35s !important",
			boxShadow: "rgba(39, 174, 96, .2) 0 6px 12px",
		},
		"&:active": {
			transform: "translateY(2px)",
			transitionDuration: ".35s !important",
		}
	}
});