<?php

namespace bbo51dog\bboformexample;

use bbo51dog\bboform\element\Button;
use bbo51dog\bboform\element\ClosureButton;
use bbo51dog\bboform\element\Dropdown;
use bbo51dog\bboform\element\Input;
use bbo51dog\bboform\element\Label;
use bbo51dog\bboform\element\Slider;
use bbo51dog\bboform\element\StepSlider;
use bbo51dog\bboform\element\Toggle;
use bbo51dog\bboform\form\ClosureCustomForm;
use bbo51dog\bboform\form\CustomForm;
use bbo51dog\bboform\form\SimpleForm;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener {

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onJoin(PlayerJoinEvent $event) {
        $nameInput = new Input("What is your name?", "name", "Steve");
        $form = (new ClosureCustomForm(function (Player $player, CustomForm $form) use ($nameInput) {
            $welcomeForm = (new SimpleForm())
                ->setText("Welcome to our server, {$nameInput->getValue()}!!\n")
                ->addElement(new ClosureButton("Done", null, function (Player $player, Button $button) {
                    $player->sendMessage("Please enjoy!");
                }));
            $player->sendForm($welcomeForm);
        }))
            ->setTitle("Example Form")
            ->addElements(
                new Label("This is the example form!!"),
                $nameInput,
                new Slider("How old are you?", 0, 100, 18),
                new StepSlider("Choose your gender", ["Male", "Female", "Others"], 2),
                new Dropdown("Where are you from?", ["Japan", "U.S.", "Others"]),
                new Toggle("Do you agree to the Terms of Use?"),
            );
        $event->getPlayer()->sendForm($form);
    }
}