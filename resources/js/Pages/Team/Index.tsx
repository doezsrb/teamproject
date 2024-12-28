import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import AuthenticatedLayoutDrawer from "@/Layouts/AuthenticatedLayoutDrawer";
import { Head, router, usePage } from "@inertiajs/react";
import {
    Box,
    Button,
    IconButton,
    List,
    ListItem,
    ListItemButton,
    ListItemText,
    Stack,
    Typography,
} from "@mui/material";
import Table from "@mui/material/Table";
import TableBody from "@mui/material/TableBody";
import TableCell from "@mui/material/TableCell";
import TableContainer from "@mui/material/TableContainer";
import TableHead from "@mui/material/TableHead";
import TableRow from "@mui/material/TableRow";
import Paper from "@mui/material/Paper";
import { useEffect } from "react";
import TaskIcon from "@mui/icons-material/Task";
export default function Index() {
    const { props }: any = usePage();
    useEffect(() => {
        console.log(props);
    }, []);
    return (
        <AuthenticatedLayoutDrawer>
            <Head title="Team" />

            <Box
                flexDirection={"column"}
                width={"100%"}
                display={"flex"}
                alignItems={"center"}
                gap={5}
            >
                <Button
                    color="inherit"
                    variant="contained"
                    onClick={() => {
                        router.visit(route("team.createform"));
                    }}
                >
                    Create Team
                </Button>
                <TableContainer
                    sx={{ width: "50%" }}
                    elevation={5}
                    component={Paper}
                >
                    <Table aria-label="simple table">
                        <TableHead>
                            <TableRow>
                                <TableCell>Team</TableCell>
                                <TableCell>Projects</TableCell>
                                <TableCell>Tasks</TableCell>
                            </TableRow>
                        </TableHead>
                        <TableBody>
                            {props.teams
                                .concat(props.createdTeams)
                                .map((team: any) => (
                                    <TableRow
                                        onClick={() => {
                                            router.visit(
                                                route("team.show", team.id)
                                            );
                                        }}
                                        key={team.name}
                                        sx={{
                                            cursor: "pointer",
                                            "&:last-child td, &:last-child th":
                                                { border: 0 },
                                        }}
                                    >
                                        <TableCell component="th" scope="row">
                                            {team.name}
                                        </TableCell>
                                        <TableCell component="th" scope="row">
                                            {team.projects_count}
                                        </TableCell>
                                        <TableCell component="th" scope="row">
                                            {team.tasks_count}
                                        </TableCell>
                                    </TableRow>
                                ))}
                        </TableBody>
                    </Table>
                </TableContainer>
            </Box>
            {/* <List
                    sx={{
                        width: "100%",

                        bgcolor: "background.paper",
                    }}
                >
                    {props.teams.concat(props.createdTeams).map((team: any) => (
                        <ListItemButton
                            onClick={() => {
                                router.visit(route("team.show", team.id));
                            }}
                            key={team.id}
                            disableGutters
                        >
                            <ListItemText primary={`${team.name}`} />
                        </ListItemButton>
                    ))}
                </List> */}
        </AuthenticatedLayoutDrawer>
    );
}
