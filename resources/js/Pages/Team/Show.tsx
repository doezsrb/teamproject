import AuthenticatedLayoutDrawer from "@/Layouts/AuthenticatedLayoutDrawer";
import { Link, router, useForm, usePage } from "@inertiajs/react";
import {
    Box,
    Button,
    DialogActions,
    DialogContent,
    DialogTitle,
    List,
    ListItemButton,
    ListItemText,
    Stack,
    TextField,
    Typography,
} from "@mui/material";
import { useEffect, useState } from "react";
import Table from "@mui/material/Table";
import TableBody from "@mui/material/TableBody";
import TableCell from "@mui/material/TableCell";
import TableContainer from "@mui/material/TableContainer";
import TableHead from "@mui/material/TableHead";
import TableRow from "@mui/material/TableRow";
import Paper from "@mui/material/Paper";
import CustomDialog from "@/Components/CustomDialog";

const Show = ({ team, projects, comments }: any) => {
    const [openDialog, setOpenDialog] = useState(false);
    const { flash } = usePage().props;
    const [openReportDialog, setOpenReportDialog] = useState(false);
    const [selectedComment, setSelectedComment] = useState(null);
    const form = useForm({
        email: "",
    });

    const reportForm = useForm({
        message: "",
    });

    const commentForm = useForm({
        comment: "",
    });
    useEffect(() => {
        console.log("flash");
        console.log(flash);
    }, [flash]);
    //!TODO: uhvatiti error za pogresni email i staviti autorizaciju na ceo sajt...npr samo admin da add user!

    const sendComment = () => {
        commentForm.post(route("create.team.comment", team.id), {
            onSuccess: () => {
                console.log("success comment");
            },
            onError: (error: any) => {
                console.log("error", error);
            },
        });
    };
    return (
        <AuthenticatedLayoutDrawer>
            <CustomDialog
                handleClose={() => {
                    setOpenReportDialog(false);
                }}
                open={openReportDialog}
            >
                <>
                    <DialogTitle>Report comment</DialogTitle>
                    <DialogContent sx={{ minWidth: 400 }}>
                        <TextField
                            sx={{ width: "100%" }}
                            value={reportForm.data.message}
                            onChange={(e: any) =>
                                reportForm.setData("message", e.target.value)
                            }
                            variant="standard"
                            multiline
                            label="Message"
                        />
                    </DialogContent>
                    <DialogActions>
                        <Button
                            onClick={() => {
                                setOpenReportDialog(false);
                            }}
                        >
                            Cancel
                        </Button>
                        <Button
                            onClick={() => {
                                if (selectedComment == null) return;
                                reportForm.put(
                                    route("report.comment", selectedComment),
                                    {
                                        onSuccess: () => {
                                            console.log("success");
                                        },
                                        onError: (error: any) => {
                                            console.log("error", error);
                                        },
                                    }
                                );
                            }}
                            variant="contained"
                            color="inherit"
                        >
                            Report
                        </Button>
                    </DialogActions>
                </>
            </CustomDialog>
            <CustomDialog
                handleClose={() => {
                    setOpenDialog(false);
                }}
                open={openDialog}
            >
                <>
                    <DialogTitle>Add user</DialogTitle>
                    <DialogContent sx={{ minWidth: 400 }}>
                        <TextField
                            sx={{ width: "100%" }}
                            value={form.data.email}
                            onChange={(e: any) =>
                                form.setData("email", e.target.value)
                            }
                            variant="standard"
                            label="User email"
                        />
                    </DialogContent>
                    <DialogActions>
                        <Button
                            onClick={() => {
                                setOpenDialog(false);
                            }}
                        >
                            Cancel
                        </Button>
                        <Button
                            onClick={() => {
                                form.post(route("team.adduser", team.id), {
                                    onSuccess: () => {
                                        console.log("success");
                                    },
                                    onError: (error: any) => {
                                        console.log("error", error);
                                    },
                                });
                            }}
                            variant="contained"
                            color="inherit"
                        >
                            Add user
                        </Button>
                    </DialogActions>
                </>
            </CustomDialog>
            <Box>
                <Typography variant="h3" align="center">
                    {team.name}
                </Typography>
                <Typography
                    variant="h6"
                    fontSize={12}
                    sx={{ opacity: 0.4 }}
                    color="black"
                    align="center"
                >
                    Owner: {team.user.email}
                </Typography>
                <div className="flex flex-col items-center gap-3 justify-center">
                    <Button
                        variant="contained"
                        color="inherit"
                        onClick={() => {
                            router.visit(route("project.create", team.id));
                        }}
                    >
                        Create Project
                    </Button>
                    <Button
                        onClick={() => {
                            setOpenDialog(true);
                        }}
                        variant="contained"
                        size="small"
                        color="inherit"
                    >
                        Add user
                    </Button>
                    {/*  <Stack
                        justifyContent={"center"}
                        mt={2}
                        direction={"row"}
                        gap={3}
                    >
                        <TextField
                            value={form.data.email}
                            onChange={(e: any) =>
                                form.setData("email", e.target.value)
                            }
                            variant="standard"
                            label="User email"
                        />
                        <Button
                            onClick={() => {
                                form.post(route("team.adduser", team.id), {
                                    onSuccess: () => {
                                        console.log("success");
                                    },
                                    onError: (error: any) => {
                                        console.log("error", error);
                                    },
                                });
                            }}
                            variant="contained"
                        >
                            Add user
                        </Button>
                    </Stack> */}
                </div>
                <Stack mt={5}>
                    <Box p={3}>
                        <Typography variant="h5" align="center">
                            Team members
                        </Typography>
                        {/* <List
                            sx={{
                                width: "100%",

                                bgcolor: "background.paper",
                            }}
                        >
                            {team.users.map((user: any) => (
                                <ListItemText
                                    key={user.id}
                                    primary={user.email}
                                />
                            ))}
                        </List> */}
                        <TableContainer component={Paper}>
                            <Table
                                sx={{ minWidth: 650 }}
                                size="small"
                                aria-label="a dense table"
                            >
                                <TableHead>
                                    <TableRow>
                                        <TableCell>Name</TableCell>
                                        <TableCell>Email</TableCell>
                                    </TableRow>
                                </TableHead>
                                <TableBody>
                                    {team.users.map((user: any) => (
                                        <TableRow
                                            key={user.email}
                                            sx={{
                                                "&:last-child td, &:last-child th":
                                                    { border: 0 },
                                            }}
                                        >
                                            <TableCell
                                                component="th"
                                                scope="row"
                                            >
                                                {user.name}
                                            </TableCell>
                                            <TableCell
                                                component="th"
                                                scope="row"
                                            >
                                                {user.email}
                                            </TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </TableContainer>
                    </Box>
                    <Box p={3} borderRadius={5}>
                        <Typography variant="h5" align="center">
                            Team projects
                        </Typography>
                        {/*  <List
                            sx={{
                                width: "100%",

                                bgcolor: "background.paper",
                            }}
                        >
                            {projects.map((project: any) => (
                                <ListItemButton
                                    onClick={() => {
                                        router.visit(
                                            route("project.show", project.id)
                                        );
                                    }}
                                    key={project.id}
                                    disableGutters
                                >
                                    <ListItemText primary={project.name} />
                                </ListItemButton>
                            ))}
                        </List> */}
                        <TableContainer component={Paper}>
                            <Table
                                sx={{ minWidth: 650 }}
                                size="small"
                                aria-label="a dense table"
                            >
                                <TableHead>
                                    <TableRow>
                                        <TableCell>Name</TableCell>
                                    </TableRow>
                                </TableHead>
                                <TableBody>
                                    {projects.map((project: any) => (
                                        <TableRow
                                            onClick={() => {
                                                router.visit(
                                                    route(
                                                        "project.show",
                                                        project.id
                                                    )
                                                );
                                            }}
                                            key={project.id}
                                            sx={{
                                                cursor: "pointer",
                                                "&:last-child td, &:last-child th":
                                                    { border: 0 },
                                            }}
                                        >
                                            <TableCell
                                                component="th"
                                                scope="row"
                                            >
                                                {project.name}
                                            </TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </TableContainer>
                    </Box>
                </Stack>

                <div className="flex flex-col justify-center gap-5">
                    <h1 className="text-xl font-bold text-center ">Comments</h1>
                    <div className="flex flex-col gap-3">
                        {comments.map((comment: any) => {
                            return (
                                <div
                                    key={comment.id}
                                    className="w-full flex flex-row gap-3 justify-between border-[1px] p-1 border-black rounded-md"
                                >
                                    <div className="w-14 h-14 rounded-full bg-red-400 "></div>
                                    <div className="flex flex-col justify-center">
                                        <p>{comment.user.email}</p>
                                        <p>{comment.comment}</p>
                                    </div>
                                    <div>
                                        <Button
                                            onClick={() => {
                                                setOpenReportDialog(true);
                                                setSelectedComment(comment.id);
                                            }}
                                        >
                                            Report
                                        </Button>
                                    </div>
                                </div>
                            );
                        })}
                    </div>
                    <Link
                        href={route("get.team.comments", {
                            team: team.id,
                            page: 1,
                        })}
                    >
                        <Button variant="outlined">Show all comments</Button>
                    </Link>

                    <textarea
                        className="rounded-md h-28"
                        value={commentForm.data.comment}
                        onChange={(e: any) => {
                            commentForm.setData("comment", e.target.value);
                        }}
                    />
                    <div className="w-full  flex flex-row ">
                        <div className="ml-auto">
                            <Button
                                onClick={sendComment}
                                variant="contained"
                                type="submit"
                            >
                                POST
                            </Button>
                        </div>
                    </div>
                </div>
            </Box>
        </AuthenticatedLayoutDrawer>
    );
};

export default Show;
